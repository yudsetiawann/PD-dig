<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight; // Import FontWeight

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama dengan style tebal & icon user
                TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-user-circle'),

                // Username & Email digabung agar hemat tempat
                TextColumn::make('username')
                    ->label('Username & Email')
                    ->description(fn($record) => $record->email)
                    ->searchable(['username', 'email'])
                    ->icon('heroicon-m-at-symbol')
                    ->sortable(),

                // Badge Role dengan ICON Spesifik
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)) // Kapitalisasi huruf awal
                    ->colors([
                        'danger' => 'admin',    // Admin warna Merah/Danger agar terlihat powerful
                        'warning' => 'scanner', // Scanner warna Kuning
                        'info' => 'user',       // User warna Biru
                    ])
                    ->icons([
                        'heroicon-m-shield-check' => 'admin', // Icon Tameng
                        'heroicon-m-qr-code' => 'scanner',    // Icon QR
                        'heroicon-m-user' => 'user',          // Icon User biasa
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter Role')
                    ->options([
                        'admin' => 'Admin',
                        'scanner' => 'Scanner',
                        'user' => 'User',
                    ])
                    ->native(false), // Dropdown modern
            ])
            ->recordActions([
                EditAction::make()->iconButton(), // Minimalis
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
