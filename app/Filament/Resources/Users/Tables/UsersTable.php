<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter; // Untuk filter role

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->badge() // Tampilkan sebagai badge
                    ->colors([ // Beri warna berbeda untuk setiap role
                        'success' => 'admin',
                        'warning' => 'scanner',
                        'gray' => 'user',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan defaultnya
            ])
            ->filters([
                // Tambahkan filter berdasarkan role
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'scanner' => 'Scanner',
                        'user' => 'User',
                    ])
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
