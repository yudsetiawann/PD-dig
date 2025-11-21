<?php

namespace App\Filament\Resources\Events\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // KOLOM KIRI (Main Content)
            Section::make('Informasi Utama')
                ->description('Masukkan detail dasar mengenai event.')
                ->icon('heroicon-o-information-circle') // Untuk Section, 'icon' BENAR
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Event')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->prefix(url('/event/') . '/')
                        ->columnSpanFull(),

                    RichEditor::make('description')
                        ->label('Deskripsi Lengkap')
                        ->columnSpanFull(),
                ])
                ->columnSpan(2),

            // KOLOM KANAN (Sidebar / Settings)
            Group::make()
                ->schema([
                    // Section Media
                    Section::make('Media')
                        ->collapsible()
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('thumbnail')
                                ->collection('thumbnails')
                                ->image()
                                ->imageEditor()
                                ->required(),

                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->collection('gallery')
                                ->multiple()
                                ->reorderable()
                                ->image()
                                ->imageEditor(),
                        ]),

                    // Section Detail & Waktu
                    Section::make('Detail & Waktu')
                        ->schema([
                            Select::make('event_type')
                                ->label('Tipe Event')
                                ->options([
                                    'ujian' => 'Ujian Kenaikan Tingkat',
                                    'pertandingan' => 'Pertandingan',
                                    'lainnya' => 'Lainnya',
                                ])
                                ->default('ujian')
                                ->required()
                                ->native(false),

                            TextInput::make('location')
                                ->label('Lokasi')
                                ->prefixIcon('heroicon-m-map-pin') // PERBAIKAN: Gunakan prefixIcon
                                ->required(),

                            DatePicker::make('starts_at')
                                ->label('Mulai')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'), // PERBAIKAN: Gunakan prefixIcon

                            DatePicker::make('ends_at')
                                ->label('Selesai')
                                ->after('starts_at')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'), // PERBAIKAN: Gunakan prefixIcon
                        ]),

                    // Section Harga & Kuota
                    Section::make('Konfigurasi Tiket')
                        ->schema([
                            Toggle::make('has_dynamic_pricing')
                                ->label('Aktifkan Harga Bertingkat')
                                ->onColor('success')
                                ->offColor('gray')
                                ->live(),

                            TextInput::make('ticket_price')
                                ->label('Harga Tiket')
                                ->numeric()
                                ->prefix('Rp')
                                ->visible(fn(Get $get): bool => !$get('has_dynamic_pricing')),

                            KeyValue::make('level_prices')
                                ->label('Daftar Harga')
                                ->keyLabel('Kategori')
                                ->valueLabel('Harga')
                                ->visible(fn(Get $get): bool => $get('has_dynamic_pricing')),

                            TextInput::make('ticket_quota')
                                ->label('Total Kuota')
                                ->numeric()
                                ->suffix('Pax')
                                ->required(),
                        ]),

                    // Fieldset untuk Kontak
                    Fieldset::make('Narahubung')
                        ->schema([
                            TextInput::make('contact_person_name')
                                ->label('Nama')
                                ->prefixIcon('heroicon-m-user') // PERBAIKAN: Tambahan icon user
                                ->placeholder('Budi Santoso'),
                            TextInput::make('contact_person_phone')
                                ->label('WhatsApp')
                                ->tel()
                                ->prefixIcon('heroicon-m-phone') // PERBAIKAN: Tambahan icon phone
                                ->prefix('+62'), // Prefix teks tetap boleh digabung dengan prefixIcon
                        ])->columns(1),

                    Hidden::make('user_id')->default(fn() => Auth::id()),
                ])
                ->columnSpan(1),
        ])->columns(3);
    }
}
