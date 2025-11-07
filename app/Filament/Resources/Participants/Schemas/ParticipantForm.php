<?php

namespace App\Filament\Resources\Participants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('school')->label('Ranting/Sekolah')->required()->maxLength(255),
                Select::make('level')
                    ->label('Tingkatan')
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
                    ])
                    ->required(),
            ]);
    }
}
