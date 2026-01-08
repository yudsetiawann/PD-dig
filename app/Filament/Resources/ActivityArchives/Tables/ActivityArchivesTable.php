<?php

namespace App\Filament\Resources\ActivityArchives\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ActivityArchivesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnail')
                    ->label('Cover')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Judul Kegiatan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Indikator Link (Opsional, agar admin tau link apa saja yang ada)
                TextColumn::make('links_count')
                    ->label('Tautan')
                    ->state(function ($record) {
                        $count = 0;
                        if ($record->link_google_drive) $count++;
                        if ($record->link_instagram) $count++;
                        if ($record->link_tiktok) $count++;
                        return $count . ' Platform';
                    })
                    ->badge()
                    ->color('info'),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                // Filter berdasarkan Tipe Event akan sangat berguna
                // SelectFilter::make('event_type')...
            ])
            ->recordActions([
                EditAction::make()->iconButton(), // Gunakan iconButton agar lebih minimalis
                DeleteAction::make()->iconButton(),
            ]);
            // ->headerActions([
            //     CreateAction::make(),
            // ]);
    }
}
