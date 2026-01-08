<?php

namespace App\Filament\Resources\ActivityArchives\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Schema; // Sesuaikan namespace Schema Filament v4 Anda

class ActivityArchiveForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul Kegiatan')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(
                                    fn(string $operation, $state, $set) =>
                                    $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                ),

                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->disabled()
                                ->dehydrated(),

                            DatePicker::make('date')
                                ->label('Tanggal Kegiatan')
                                ->required()
                                ->native(false),
                        ]),

                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Media & Tautan')
                    ->schema([
                        // Integrasi Spatie Media Library
                        SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->label('Thumbnail Kegiatan')
                            ->collection('thumbnail') // Sesuai definisi di Model
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048) // Max 2MB
                            ->helperText('Upload 1 foto terbaik sebagai cover. Dokumentasi lengkap simpan di link eksternal.')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            TextInput::make('link_google_drive')
                                ->label('Link Google Drive')
                                ->url()
                                ->prefixIcon('heroicon-m-cloud'),

                            TextInput::make('link_instagram')
                                ->label('Link Instagram')
                                ->url()
                                ->prefixIcon('heroicon-m-camera'),

                            TextInput::make('link_tiktok')
                                ->label('Link TikTok')
                                ->url()
                                ->prefixIcon('heroicon-m-video-camera'),
                        ]),
                    ]),
            ]);
    }
}
