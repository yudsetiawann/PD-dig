<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\SendETicket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        Log::info('Midtrans notification received:', $request->all());

        $payload = $request->all();

        $orderId    = $payload['order_id'];
        $serverKey  = config('midtrans.server_key');
        $ourSignatureKey = hash('sha512', $orderId . $payload['status_code'] . $payload['gross_amount'] . $serverKey);

        if ($payload['signature_key'] !== $ourSignatureKey) {
            Log::error('Signature key tidak valid untuk order_code: ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_code', $orderId)->first();

        if (!$order) {
            Log::warning('Order tidak ditemukan untuk order_code: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Notification already processed'], 200);
        }

        $transactionStatus = $payload['transaction_status'];

        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $ticketCode = 'TIX-' . strtoupper(Str::random(10));

            // Semua perubahan data kritis dalam satu transaksi atomik
            DB::transaction(function () use ($order, $ticketCode) {
                $order->update([
                    'status'      => 'paid',
                    'ticket_code' => $ticketCode,
                ]);

                // Atomic increment/decrement — aman dari race condition concurrent webhook
                $order->event()->increment('ticket_sold', $order->quantity);
                $order->event()->decrement('ticket_quota', $order->quantity);
            });

            Log::info('Order berhasil dipaid dan stok tiket diupdate untuk: ' . $orderId);

            // PDF generation dan email di luar transaksi — kegagalan di sini
            // tidak akan rollback pembayaran yang sudah tercatat
            try {
                $pdf = Pdf::loadView('pdf.eticket', ['order' => $order->fresh()]);
                $tempPdfPath = storage_path('app/temp/' . $ticketCode . '.pdf');
                $pdf->save($tempPdfPath);
                $order->addMedia($tempPdfPath)->toMediaCollection('etickets');
                Log::info('PDF E-Ticket berhasil dibuat untuk: ' . $orderId);
            } catch (\Exception $e) {
                Log::error('Gagal membuat PDF e-ticket untuk order ' . $orderId . ': ' . $e->getMessage());
            }

            try {
                Mail::to($order->user->email)->send(new SendETicket($order));
                Log::info('Email e-ticket berhasil dikirim ke: ' . $order->user->email);
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email e-ticket untuk order ' . $orderId . ': ' . $e->getMessage());
            }

        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->update(['status' => 'failed']);
            Log::info('Status order diupdate menjadi "failed" untuk: ' . $orderId);
        }

        return response()->json(['message' => 'Notification handled successfully'], 200);
    }
}
