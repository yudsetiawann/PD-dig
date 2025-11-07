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

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('school')->label('Ranting/Sekolah')->searchable()->sortable(),
                TextColumn::make('level')->label('Tingkatan')->searchable()->sortable(),
                TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter dinamis berdasarkan data unik dari database
                SelectFilter::make('school')
                    ->label('Ranting/Sekolah')
                    ->options(
                        fn() => Participant::query()
                            ->pluck('school', 'school')
                            ->unique()
                            ->sort()
                            ->toArray()
                    )
                    ->searchable(),

                SelectFilter::make('level')
                    ->label('Tingkatan')
                    ->options(
                        fn() => Participant::query()
                            ->pluck('level', 'level')
                            ->unique()
                            ->sort()
                            ->toArray()
                    )
                    ->searchable(),
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
