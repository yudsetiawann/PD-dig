<?php

namespace App\Filament\Resources\OrganizationPositions\Pages;

use App\Filament\Resources\OrganizationPositions\OrganizationPositionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationPosition extends EditRecord
{
    protected static string $resource = OrganizationPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
