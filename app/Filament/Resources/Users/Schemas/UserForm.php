<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true) // Pastikan unik
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true) // Unik kecuali record saat ini
                    ->maxLength(255),
                Select::make('role')
                    ->required()
                    ->options([ // Definisikan role yang tersedia
                        'admin' => 'Admin',
                        'scanner' => 'Scanner',
                        'user' => 'User',
                    ])
                    ->default('user'), // Default role
                TextInput::make('password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create') // Wajib saat membuat baru
                    ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? Hash::make($state) : null) // Hash password jika diisi
                    ->dehydrated(fn(?string $state): bool => filled($state)) // Hanya simpan jika diisi (agar tidak menimpa saat edit jika kosong)
                    ->revealable()
                    ->rule(Password::defaults()), // Gunakan aturan password default Laravel
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn(string $operation, Get $get): bool => $operation === 'create' || filled($get('password'))) // Wajib jika password diisi
                    ->same('password') // Harus sama dengan field password
                    ->revealable()
                    ->dehydrated(false), // Jangan simpan konfirmasi password
            ]);
    }
}
