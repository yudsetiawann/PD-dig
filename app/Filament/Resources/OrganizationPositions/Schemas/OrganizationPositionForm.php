<?php

namespace App\Filament\Resources\OrganizationPositions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;

class OrganizationPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Jabatan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('order_level')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0)
                    ->helperText('Angka lebih kecil akan muncul lebih awal di dropdown.'),

                Toggle::make('is_active')
                    ->label('Aktif?')
                    ->default(true),
            ]);
    }
}
