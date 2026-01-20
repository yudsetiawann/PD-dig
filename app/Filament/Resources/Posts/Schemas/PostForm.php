<?php

namespace App\Filament\Resources\Posts\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Berita')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('Judul')
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

                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'Materi Edukasi' => 'Materi Edukasi (Sejarah, Teknik, Filosofi)',
                                    'Info Pertandingan' => 'Info Pertandingan (Peraturan, Teknis)',
                                    'Berita Event' => 'Berita Event (Juara, Highlight)',
                                ])
                                ->required(),

                            DatePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->default(now())
                                ->required(),
                        ]),

                        RichEditor::make('content')
                            ->label('Isi Konten')
                            ->fileAttachmentsDisk('public') // Agar gambar di editor tersimpan
                            ->fileAttachmentsDirectory('posts/content')
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Section::make('Pengaturan & Media')
                    ->schema([
                        ToggleButtons::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Publish',
                            ])
                            ->colors([
                                'draft' => 'gray',
                                'published' => 'success',
                            ])
                            ->default('draft')
                            ->inline(),

                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label('Gambar Sampul')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
