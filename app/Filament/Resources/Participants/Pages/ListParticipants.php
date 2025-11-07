<?php

namespace App\Filament\Resources\Participants\Pages;

use App\Filament\Resources\Participants\ParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ImportAction;
use App\Imports\ParticipantImporter;

class ListParticipants extends ListRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Anggota'),

            ImportAction::make()
                ->label('Impor dari Excel')
                ->importer(ParticipantImporter::class)
                ->color('success'),
        ];
    }
}
