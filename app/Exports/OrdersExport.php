<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder; // Penting untuk query
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Opsional: agar kolom rapi

class OrdersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected int $eventId;

    /**
     * Kita akan mengirimkan ID event ke sini
     */
    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Mengambil data dari database.
     * Kita hanya ambil order yang LUNAS (paid) untuk event ini.
     */
    public function query(): Builder
    {
        return Order::query()
            ->where('event_id', $this->eventId)
            ->where('status', 'paid');
    }

    /**
     * Menentukan header kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Ranting/Sekolah',
            'Tingkatan (Sabuk)',
            'Tingkat (Usia)',
            'Kategori',
            'Kode Tiket',
            'Status Bayar',
            'Waktu Check-In',
        ];
    }

    /**
     * Memetakan data dari $order ke setiap kolom Excel.
     *
     * @param Order $order
     */
    public function map($order): array
    {
        return [
            $order->customer_name,
            $order->school,
            $order->level, // Kolom 'level' (Sabuk)
            $order->competition_level ?? '-', // Kolom 'competition_level' (Usia)
            $order->category ?? '-', // Kolom 'category' (Kategori Tanding)
            $order->ticket_code,
            ucfirst($order->status),
            $order->checked_in_at ? $order->checked_in_at->format('d M Y H:i') : 'Belum Check-in',
        ];
    }
}
