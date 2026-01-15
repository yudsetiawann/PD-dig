<?php

namespace App\Filament\Resources\OrganizationPositions;

use App\Filament\Resources\OrganizationPositions\Pages\CreateOrganizationPosition;
use App\Filament\Resources\OrganizationPositions\Pages\EditOrganizationPosition;
use App\Filament\Resources\OrganizationPositions\Pages\ListOrganizationPositions;
use App\Filament\Resources\OrganizationPositions\Schemas\OrganizationPositionForm;
use App\Filament\Resources\OrganizationPositions\Tables\OrganizationPositionsTable;
use App\Models\OrganizationPosition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrganizationPositionResource extends Resource
{
    protected static ?string $model = OrganizationPosition::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Anggota';
    protected static ?string $navigationLabel = 'Jabatan Organisasi';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationPositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationPositionsTable::configure($table);
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
            'index' => ListOrganizationPositions::route('/'),
            'create' => CreateOrganizationPosition::route('/create'),
            'edit' => EditOrganizationPosition::route('/{record}/edit'),
        ];
    }
}
