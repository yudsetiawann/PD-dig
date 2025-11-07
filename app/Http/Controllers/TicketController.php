<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf; // Akan diinstall nanti
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Menampilkan halaman "Tiket Saya"
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('event:id,title') // Hanya ambil ID dan title event
            ->latest()
            ->paginate(10);
        return view('profile.my-tickets', compact('orders'));
    }

    // Menampilkan E-Ticket PDF di browser
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat tiket miliknya dan sudah lunas
        if ($order->user_id !== auth()->id() || $order->status !== 'paid' || !$order->ticket_code) {
            abort(403);
        }
        $pdf = Pdf::loadView('pdf.eticket', compact('order'));
        return $pdf->stream('e-ticket-' . $order->ticket_code . '.pdf');
    }

    // Mengunduh E-Ticket PDF
    public function download(Order $order)
    {
        // Pastikan user hanya bisa download tiket miliknya dan sudah lunas
        if ($order->user_id !== auth()->id() || $order->status !== 'paid') {
            abort(403);
        }
        $ticketMedia = $order->getFirstMedia('etickets');
        if ($ticketMedia) {
            return $ticketMedia; // Spatie akan menangani response download
        } else {
            // Jika file tidak ditemukan (sebagai fallback)
            $pdf = Pdf::loadView('pdf.eticket', compact('order'));
            return $pdf->download('e-ticket-' . $order->ticket_code . '.pdf');
        }
    }

    // Membatalkan order yang masih pending
    public function cancel(Order $order)
    {
        // Pastikan user hanya bisa cancel tiket miliknya dan masih pending
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            abort(403);
        }
        $order->delete();
        return redirect()->route('my-tickets.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
