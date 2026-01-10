<?php

namespace App\Filament\Resources\OrganizationPositions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class OrganizationPositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order_level', 'asc') // Default sort table
            ->columns([
                TextColumn::make('name')
                    ->label('Jabatan')
                    ->searchable(),

                TextColumn::make('order_level')
                    ->label('Urutan')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
