<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class SalesStatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    // method untuk mengatur jumlah kolom menjadi 2
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        // Data Transaksi
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $totalTicketsSold = Order::where('status', 'paid')->sum('quantity');

        // Data User (Atlet & Pelatih)
        $totalAthletes = User::where('role', 'user')->count();
        $totalCoaches = User::where('role', 'coach')->count();

        return [
            // 1. Stat Pendapatan
            Stat::make('Total Pendapatan', Number::currency($totalRevenue, 'IDR'))
                ->description('Total Income')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([70000, 150000, 120000, 200000, $totalRevenue])
                ->color('success'), // Hijau

            // 2. Stat Tiket
            Stat::make('Tiket Terjual', $totalTicketsSold . ' Tiket')
                ->description('Transaksi lunas')
                ->descriptionIcon('heroicon-m-ticket')
                ->chart([5, 10, 8, 15, 20, $totalTicketsSold])
                ->color('gray'),

            // 3. Stat Atlet (Dari tabel User)
            Stat::make('Total Atlet', $totalAthletes . ' Orang')
                ->description('Anggota terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->chart([50, 80, 100, 120, $totalAthletes])
                ->color('info'), // Biru

            // 4. Stat Pelatih (Baru)
            Stat::make('Total Pelatih', $totalCoaches . ' Orang')
                ->description('Pelatih aktif')
                ->descriptionIcon('heroicon-m-academic-cap') // Ikon Topi Akademik/Pelatih
                ->chart([2, 5, 7, 10, $totalCoaches])
                ->color('warning'), // Oranye/Kuning
        ];
    }
}
