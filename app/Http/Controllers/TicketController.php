<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Menampilkan halaman "Tiket Saya"
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->paginate(10);
        return view('profile.my-tickets', compact('orders'));
    }

    // Menampilkan E-Ticket PDF di browser
    public function show(Order $order)
    {
        $this->authorize('downloadTicket', $order);

        $pdf = Pdf::loadView('pdf.eticket', compact('order'));
        return $pdf->stream('e-ticket-' . $order->ticket_code . '.pdf');
    }

    // Mengunduh E-Ticket PDF
    public function download(Order $order)
    {
        $this->authorize('downloadTicket', $order);

        $ticketMedia = $order->getFirstMedia('etickets');
        if ($ticketMedia) {
            return $ticketMedia;
        } else {
            $pdf = Pdf::loadView('pdf.eticket', compact('order'));
            return $pdf->download('e-ticket-' . $order->ticket_code . '.pdf');
        }
    }

    // Membatalkan order yang masih pending
    public function cancel(Order $order)
    {
        $this->authorize('pay', $order);

        $order->update(['status' => 'cancelled']);
        return redirect()->route('my-tickets.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
