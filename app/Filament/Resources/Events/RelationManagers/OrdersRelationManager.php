<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Models\Order;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Filament\Support\Enums\FontWeight; // Jangan lupa import ini

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
    protected static ?string $title = 'Peserta Terdaftar & Transaksi';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_code')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        // Ambil tipe event dari record induk (Event)
        $eventType = $this->getOwnerRecord()->event_type;

        return $table
            ->recordTitleAttribute('order_code')
            ->columns([
                // 1. Kolom Nama digabung dengan Kode Order (Modern Look)
                TextColumn::make('customer_name')
                    ->label('Nama Peserta')
                    ->weight(FontWeight::Bold) // Nama dipertebal
                    ->icon('heroicon-m-user')
                    ->description(fn(Order $record) => $record->order_code) // Kode order jadi sub-text
                    ->searchable(['customer_name', 'order_code']) // Bisa cari nama atau kode
                    ->sortable(),

                // 2. Kolom Sekolah dengan Icon
                TextColumn::make('school')
                    ->label('Ranting/Sekolah')
                    ->icon('heroicon-m-building-library')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                // 3. Level dengan Warna Warni (Konsisten dengan ParticipantsTable)
                TextColumn::make('level')
                    ->label($eventType === 'ujian' ? 'Tingkatan' : 'Tingkat')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Hijau', 'Putih Hijau', 'Hijau Biru' => 'success', // Warna Hijau
                        'Biru' => 'info',    // Warna Biru
                        'Cakel' => 'warning', // Warna Kuning
                        'Pemula', 'Dasar I', 'Dasar II' => 'gray', // Warna Abu
                        default => 'primary',
                    })
                    ->searchable()
                    ->sortable(),

                // 4. Status Bayar dengan Icon & Warna
                TextColumn::make('status')
                    ->label('Status Bayar')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'pending',
                        'danger' => fn($state) => in_array($state, ['failed', 'expired']),
                    ])
                    ->icons([
                        'heroicon-m-check-badge' => 'paid',
                        'heroicon-m-clock' => 'pending',
                        'heroicon-m-x-circle' => ['failed', 'expired'],
                    ])
                    ->sortable(),

                // 5. Harga
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->weight(FontWeight::Bold)
                    ->sortable(),

                // 6. Waktu Check-in (Penting untuk panitia)
                TextColumn::make('checked_in_at')
                    ->label('Check-in')
                    ->dateTime('d M H:i')
                    ->placeholder('Belum Hadir') // Teks jika kosong
                    ->badge() // Tampil sebagai badge agar menonjol
                    ->color(fn($state) => $state ? 'success' : 'gray')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas (Paid)',
                        'failed' => 'Gagal (Failed)',
                        'expired' => 'Kedaluwarsa (Expired)',
                    ])
                    ->native(false),

                SelectFilter::make('level')
                    ->label($eventType === 'ujian' ? 'Tingkatan' : 'Tingkat')
                    ->options(function () {
                        return Order::where('event_id', $this->getOwnerRecord()->id)
                            ->select('level')
                            ->distinct()
                            ->whereNotNull('level')
                            ->pluck('level', 'level')
                            ->toArray();
                    })
                    ->native(false),

                Filter::make('school')
                    ->label('Ranting/Sekolah')
                    ->schema([
                        TextInput::make('school_name')
                            ->label('Cari Ranting/Sekolah')
                            ->prefixIcon('heroicon-m-magnifying-glass'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['school_name'],
                                fn(Builder $query, $name): Builder => $query->where('school', 'like', "%{$name}%"),
                            );
                    }),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Ekspor Data (XLSX)')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        $eventId = $this->getOwnerRecord()->id;
                        $eventSlug = $this->getOwnerRecord()->slug ?? 'event';
                        $fileName = 'Peserta-' . $eventSlug . '-' . now()->format('d-m-Y') . '.xlsx';

                        return Excel::download(new OrdersExport($eventId), $fileName);
                    }),
            ])
            ->recordActions([
                EditAction::make()->iconButton(), // Ubah jadi tombol icon agar ringkas
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
