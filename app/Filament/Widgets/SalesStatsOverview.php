<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Participant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class SalesStatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $totalTicketsSold = Order::where('status', 'paid')->sum('quantity');
        $totalParticipants = Participant::count();

        // Contoh data chart (Array angka statis, atau bisa ambil dari query database per hari)
        // Di real project, Anda bisa query: Order::selectRaw('count(*) as count')->groupBy('created_at')->pluck('count')->toArray();
        $chartData = [15, 10, 20, 35, 25, 40, 50];

        return [
            Stat::make('Total Pendapatan', Number::currency($totalRevenue, 'IDR'))
                ->description('Pemasukan bersih')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([70000, 150000, 120000, 200000, $totalRevenue]) // Dummy chart tren pendapatan
                ->color('success'), // Hijau

            Stat::make('Tiket Terjual', $totalTicketsSold . ' Tiket')
                ->description('Transaksi lunas')
                ->descriptionIcon('heroicon-m-ticket')
                ->chart([5, 10, 8, 15, 20, $totalTicketsSold]) // Dummy chart tren penjualan
                ->color('primary'), // Amber/Sesuai tema

            Stat::make('Total Atlet', $totalParticipants . ' Orang')
                ->description('Peserta terdaftar di database')
                ->descriptionIcon('heroicon-m-users')
                ->chart([100, 120, 140, 150, $totalParticipants]) // Dummy chart pertumbuhan user
                ->color('info'), // Biru
        ];
    }
}
