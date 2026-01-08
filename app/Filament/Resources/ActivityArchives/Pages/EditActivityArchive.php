<?php

namespace App\Filament\Resources\ActivityArchives\Pages;

use App\Filament\Resources\ActivityArchives\ActivityArchiveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditActivityArchive extends EditRecord
{
    protected static string $resource = ActivityArchiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
