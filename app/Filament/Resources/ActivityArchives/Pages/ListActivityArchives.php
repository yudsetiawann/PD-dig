<?php

namespace App\Filament\Resources\ActivityArchives\Pages;

use App\Filament\Resources\ActivityArchives\ActivityArchiveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListActivityArchives extends ListRecords
{
    protected static string $resource = ActivityArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
