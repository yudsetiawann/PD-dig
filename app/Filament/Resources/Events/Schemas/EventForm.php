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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // --- GRUP KIRI (Main Content: 2/3 layar) ---
            Group::make()
                ->schema([
                    Section::make('Informasi Utama')
                        ->description('Masukkan detail dasar mengenai event.')
                        ->icon('heroicon-o-information-circle')
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
                        ]),

                    Section::make('Media')
                        ->collapsible()
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('thumbnail')
                                ->label('Thumbnail Utama')
                                ->collection('thumbnails')
                                ->image()
                                ->imageEditor()
                                ->required(),

                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->label('Galeri Dokumentasi')
                                ->collection('gallery')
                                ->multiple()
                                ->reorderable()
                                ->image()
                                ->imageEditor(),
                        ]),
                ])
                ->columnSpan(['lg' => 2]),

            // --- GRUP KANAN (Sidebar: 1/3 layar) ---
            Group::make()
                ->schema([
                    Section::make('Detail & Waktu')
                        ->icon('heroicon-o-calendar')
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
                                ->prefixIcon('heroicon-m-map-pin')
                                ->required(),

                            DatePicker::make('starts_at')
                                ->label('Mulai')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'),

                            DatePicker::make('ends_at')
                                ->label('Selesai')
                                ->after('starts_at')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'),
                        ]),

                    Section::make('Konfigurasi Tiket')
                        ->icon('heroicon-o-ticket')
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
                                ->visible(fn(Get $get): bool => $get('has_dynamic_pricing'))
                                ->columnSpanFull(),

                            TextInput::make('ticket_quota')
                                ->label('Total Kuota')
                                ->numeric()
                                ->suffix('Pax')
                                ->required(),
                        ]),

                    Section::make('Narahubung')
                        ->schema([
                            TextInput::make('contact_person_name')
                                ->label('Nama')
                                ->prefixIcon('heroicon-m-user')
                                ->placeholder('Budi Santoso'),
                            TextInput::make('contact_person_phone')
                                ->label('WhatsApp')
                                ->tel()
                                ->prefixIcon('heroicon-m-phone')
                                ->prefix('+62'),
                        ]),

                    Hidden::make('user_id')->default(fn() => Auth::id()),
                ])
                ->columnSpan(['lg' => 1]),

            // --- SECTION BAWAH (Full Width) ---
            // Dipisah agar setting yang kompleks ini memiliki ruang yang cukup
            Section::make('Pengaturan Sertifikat')
                ->description('Konfigurasi template dan tata letak sertifikat.')
                ->icon('heroicon-o-academic-cap')
                ->collapsed() // Default tertutup agar halaman tidak terlalu panjang
                ->columnSpanFull()
                ->schema([
                    Group::make()->schema([
                        // Uploader Depan
                        SpatieMediaLibraryFileUpload::make('front_image')
                            ->label('Template Depan')
                            ->collection('certificate_front')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120),

                        // Uploader Belakang
                        SpatieMediaLibraryFileUpload::make('back_image')
                            ->label('Template Belakang')
                            ->collection('certificate_back')
                            ->image()
                            ->imageEditor(),
                    ])->columns(2),

                    Group::make()->schema([
                        Toggle::make('is_certificate_published')
                            ->label('Terbitkan Sertifikat')
                            ->inline(false),

                        Select::make('certificate_settings.orientation')
                            ->label('Orientasi Kertas')
                            ->options([
                                'landscape' => 'Landscape (Melebar)',
                                'portrait' => 'Portrait (Tegak)',
                            ])
                            ->default('landscape')
                            ->selectablePlaceholder(false),
                    ])->columns(2),

                    Section::make('Tata Letak Teks')
                        ->schema([
                            TextInput::make('certificate_settings.name_top_margin')
                                ->label('Jarak Nama (Y)')
                                ->numeric()
                                ->suffix('px')
                                ->default(300),

                            TextInput::make('certificate_settings.status_top_margin')
                                ->label('Jarak Status (Y)')
                                ->numeric()
                                ->suffix('px')
                                ->default(450),

                            TextInput::make('certificate_settings.font_color')
                                ->label('Warna Teks')
                                ->default('#000000')
                                ->prefix('#'),
                        ])->columns(3),
                ]),

        ])->columns(3);
    }
}
