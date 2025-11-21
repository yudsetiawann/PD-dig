<?php

namespace App\Filament\Resources\Participants\Tables;

use Filament\Tables\Table;
use App\Models\Participant;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama dibuat tebal dengan icon user
                TextColumn::make('name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-user')
                    ->color('gray'),

                // Sekolah diberi icon gedung/topi sarjana
                TextColumn::make('school')
                    ->label('Ranting / Sekolah')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-academic-cap')
                    ->wrap(), // Wrap teks jika nama sekolah panjang

                // Level menggunakan BADGE dengan warna dinamis
                TextColumn::make('level')
                    ->label('Tingkatan')
                    ->badge() // Mengubah teks jadi badge kotak
                    ->sortable()
                    ->searchable()
                    ->color(fn(string $state): string => match ($state) {
                        'Hijau', 'Putih Hijau', 'Hijau Biru' => 'success', // Hijau
                        'Biru' => 'info',    // Biru
                        'Cakel' => 'warning', // Kuning/Oranye
                        'Pemula', 'Dasar I', 'Dasar II' => 'gray', // Abu-abu
                        default => 'primary',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Terdaftar')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter Sekolah
                SelectFilter::make('school')
                    ->label('Filter Sekolah')
                    ->searchable()
                    ->indicator('Sekolah') // Indikator saat filter aktif
                    ->options(
                        static fn() => Participant::query()
                            ->select('school')
                            ->distinct()
                            ->orderBy('school')
                            ->pluck('school', 'school')
                            ->toArray()
                    )
                    ->getOptionLabelUsing(fn($value) => $value),

                // Filter Tingkatan
                SelectFilter::make('level')
                    ->label('Filter Tingkatan')
                    ->multiple() // Bisa pilih lebih dari 1 tingkatan
                    ->options([
                        'Pemula' => 'Pemula',
                        'Dasar I' => 'Dasar I',
                        'Dasar II' => 'Dasar II',
                        'Cakel' => 'Cakel',
                        'Putih' => 'Putih',
                        'Putih Hijau' => 'Putih Hijau',
                        'Hijau' => 'Hijau',
                        'Hijau Biru' => 'Hijau Biru',
                        'Biru' => 'Biru',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->iconButton(), // Ubah jadi icon button agar rapi
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
