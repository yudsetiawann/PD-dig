<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\MidtransService; // Pastikan import ini ada
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order, MidtransService $midtrans)
    {
        // 1. Validasi Akses
        if ((int)$order->user_id !== (int)auth()->id() || $order->status !== 'pending') {
            abort(403);
        }

        // 2. CEK APAKAH TOKEN PERLU DI-GENERATE ULANG?
        // Kondisi: Jika token kosong di DB, kita buatkan baru.
        // Catatan: Idealnya kita juga cek expiry, tapi mengecek kosong saja sudah membantu banyak kasus.
        if (empty($order->midtrans_token)) {

            // --- LOGIKA MENYUSUN PARAMETER MIDTRANS (Sama seperti di OrderController) ---

            // Susun Item Name (Copied from OrderController logic)
            $itemName = 'Tiket ' . $order->event->title;
            $details = [];
            if ($order->level) $details[] = $order->level;
            if ($order->competition_level) $details[] = $order->competition_level;
            if ($order->category) $details[] = $order->category;
            if ($order->class) $details[] = $order->class;

            if (!empty($details)) {
                $itemName .= ' (' . implode(', ', $details) . ')';
            }

            // Parameter Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code, // Gunakan order code yang sama
                    'gross_amount' => (int) $order->total_price,
                ],
                'item_details' => [[
                    'id'       => $order->event_id,
                    'price'    => (int) ($order->total_price / $order->quantity), // Asumsi harga per item rata
                    'quantity' => (int) $order->quantity,
                    'name'     => substr($itemName, 0, 50)
                ]],
                'customer_details' => [
                    'first_name' => $order->customer_name, // Ambil dari data order yg tersimpan
                    'phone'      => $order->phone_number,
                    'email'      => Auth::user()->email,
                ],
                'enabled_payments' => ['bca_va', 'echannel', 'gopay', 'shopeepay', 'qris', 'other_qris']
            ];

            try {
                // Minta token baru ke Midtrans
                $snap = $midtrans->createTransaction($params);

                // Update token baru ke database
                $order->update(['midtrans_token' => $snap->token]);
            } catch (\Exception $e) {
                // Jika gagal generate token (misal koneksi error), kembalikan error ke view
                return back()->with('error', 'Gagal memproses token pembayaran: ' . $e->getMessage());
            }
        }

        return view('payment', compact('order'));
    }
}
