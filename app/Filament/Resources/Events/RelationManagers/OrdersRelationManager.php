<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Models\Order;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\RelationManagers\RelationManager;
use Maatwebsite\Excel\Facades\Excel; // Import Fassad Excel
use App\Exports\OrdersExport; // Import class Exporter baru Anda

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
                TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default (selalu 1)

                TextColumn::make('customer_name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),

                // --- KOLOM BARU / DIPERBARUI ---
                TextColumn::make('school')
                    ->label('Ranting/Sekolah')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('level')
                    // Label dinamis berdasarkan tipe event
                    ->label($eventType === 'ujian' ? 'Tingkatan' : 'Tingkat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Bayar')
                    ->badge()
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'pending',
                        'danger' => fn($state) => in_array($state, ['failed', 'expired']),
                    ])
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Tiket')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_price')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('checked_in_at')
                    ->label('Waktu Check-in')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Tanggal Pesan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas (Paid)',
                        'failed' => 'Gagal (Failed)',
                        'expired' => 'Kedaluwarsa (Expired)',
                    ]),

                // Filter Tingkatan
                SelectFilter::make('level')
                    ->label($eventType === 'ujian' ? 'Tingkatan' : 'Tingkat')
                    ->options(function () {
                        // Ambil opsi unik dari order yang ada untuk event ini saja
                        return Order::where('event_id', $this->getOwnerRecord()->id)
                            ->select('level')
                            ->distinct()
                            ->whereNotNull('level') // Abaikan jika null
                            ->pluck('level', 'level') // value => label
                            ->toArray();
                    }),

                // Filter berdasarkan Ranting/Sekolah (menggunakan input teks)
                Filter::make('school')
                    ->label('Ranting/Sekolah')
                    ->schema([
                        TextInput::make('school_name')
                            ->label('Cari Ranting/Sekolah'),
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
                // CreateAction::make(),
                // AssociateAction::make(),
                // --- TAMBAHKAN TOMBOL EKSPOR DI SINI ---
                Action::make('export')
                    ->label('Ekspor Data Peserta (XLSX)')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        // Ambil ID event saat ini
                        $eventId = $this->getOwnerRecord()->id;
                        $eventSlug = $this->getOwnerRecord()->slug;
                        $fileName = 'data-peserta-' . $eventSlug . '-' . now()->format('Y-m-d') . '.xlsx';

                        // Panggil Maatwebsite/Excel secara langsung
                        // Ini akan memicu download langsung di browser
                        return Excel::download(new OrdersExport($eventId), $fileName);
                    }), // Atur nama file
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    BulkActionGroup::make([]),
                ]),
            ]);
    }
}
