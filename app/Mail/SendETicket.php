<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class SendETicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Properti untuk menampung data order.
     */
    public Order $order;

    /**
     * Buat instance pesan baru.
     * Menerima objek Order saat dibuat.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Dapatkan amplop (subjek, pengirim, dll.) pesan.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket Anda untuk ' . $this->order->event->title,
        );
    }

    /**
     * Dapatkan definisi konten pesan.
     * Mengarah ke view Blade untuk isi email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.eticket-notification',
        );
    }

    /**
     * Lampiran untuk pesan.
     * Melampirkan PDF e-ticket.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Ambil file e-ticket dari Spatie Media Library
        $eticket = $this->order->getFirstMedia('etickets');

        // Jika file ditemukan, lampirkan
        if ($eticket) {
            return [
                Attachment::fromPath($eticket->getPath())
                    ->as($eticket->file_name)
                    ->withMime($eticket->mime_type),
            ];
        }

        return [];
    }
}
