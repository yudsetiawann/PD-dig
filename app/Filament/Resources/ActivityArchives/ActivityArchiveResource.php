<?php

namespace App\Filament\Resources\ActivityArchives;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\ActivityArchive;
use Filament\Resources\Resource;
use App\Filament\Resources\ActivityArchives\Pages\EditActivityArchive;
use App\Filament\Resources\ActivityArchives\Pages\ListActivityArchives;
use App\Filament\Resources\ActivityArchives\Pages\CreateActivityArchive;
use App\Filament\Resources\ActivityArchives\Schemas\ActivityArchiveForm;
use App\Filament\Resources\ActivityArchives\Tables\ActivityArchivesTable;
use UnitEnum;

class ActivityArchiveResource extends Resource
{
    protected static ?string $model = ActivityArchive::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    // 2. Mengganti Nama Menu di Sidebar
    protected static ?string $navigationLabel = 'Arsip Kegiatan';
    // Mengganti judul di header halaman dan tombol "New"
    protected static ?string $modelLabel = 'Arsip Kegiatan';
    protected static ?string $pluralModelLabel = 'Arsip Kegiatan';

    // Grouping
    protected static ?int $navigationSort = 3;
    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Event';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ActivityArchiveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityArchivesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityArchives::route('/'),
            'create' => CreateActivityArchive::route('/create'),
            'edit' => EditActivityArchive::route('/{record}/edit'),
        ];
    }
}
