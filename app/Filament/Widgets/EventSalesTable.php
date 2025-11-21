<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn; // Jika pakai spatie

class EventSalesTable extends BaseWidget
{
    protected static ?string $heading = 'Performansi Event Terkini';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = true;
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->where('ends_at', '>=', now()->subMonths(6)) // Rentang waktu diperluas
                    ->orderBy('starts_at', 'desc')
            )
            ->columns([
                // 1. Tambahkan Gambar agar visual
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnails')
                    ->circular()
                    ->label('Img'),

                // 2. Judul dipertebal
                TextColumn::make('title')
                    ->label('Event')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn(Event $record) => $record->location) // Lokasi jadi sub-text
                    ->limit(30),

                // 3. Badge Warna Warni untuk Status Kuota
                TextColumn::make('ticket_quota')
                    ->label('Sisa Kuota')
                    ->badge()
                    ->color(fn($state) => $state < 10 ? 'danger' : 'success') // Merah jika < 10
                    ->formatStateUsing(fn($state) => $state . ' Pax'),

                TextColumn::make('ticket_sold')
                    ->label('Terjual')
                    ->icon('heroicon-m-check-circle')
                    ->numeric(),

                // 4. Format Tanggal dengan Badge Status
                TextColumn::make('starts_at')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state > now() ? 'Akan Datang' : 'Selesai')
                    ->color(fn($state) => $state > now() ? 'warning' : 'gray'),
            ])
            ->paginated(false) // Matikan pagination agar terlihat seperti list ringkas
            ->recordUrl(fn(Event $record) => route('filament.admin.resources.events.edit', $record)); // Bisa diklik menuju edit
    }
}
