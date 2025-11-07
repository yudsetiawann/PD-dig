<?php

namespace App\Imports;

use App\Models\Participant;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ParticipantImporter extends Importer
{
    protected static ?string $model = Participant::class; // <-- Tentukan modelnya di sini

    public static function getColumns(): array
    {
        // Petakan kolom Excel Anda ke kolom database
        return [
            ImportColumn::make('name')
                ->requiredMapping() // Wajib ada di file Excel
                ->rules(['required', 'string', 'max:255']) // Validasi data
                ->castStateUsing(fn($state) => trim($state)), // Bersihkan spasi

            ImportColumn::make('school')
                // ->header('ranting_sekolah') // <-- Sesuaikan dengan nama header Excel Anda
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->castStateUsing(fn($state) => trim($state)),

            ImportColumn::make('level')
                // ->header('tingkatan') // <-- Sesuaikan dengan nama header Excel Anda
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->castStateUsing(fn($state) => trim($state)),
        ];
    }

    public function resolveRecord(): ?Participant
    {
        // Mencegah data duplikat berdasarkan nama
        return Participant::firstOrNew([
            'name' => $this->data['name'],
        ]);

        // Jika ingin menambah tanpa cek duplikat:
        // return new Participant();
    }

    /**
     * Fungsi ini dipanggil oleh Filament untuk mendapatkan ringkasan
     */
    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor data peserta Anda telah selesai dan ' . number_format($import->successful_rows) . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->failed_rows) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
