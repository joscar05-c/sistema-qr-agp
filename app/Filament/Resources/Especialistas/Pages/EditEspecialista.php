<?php

namespace App\Filament\Resources\Especialistas\Pages;

use App\Filament\Resources\Especialistas\EspecialistaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEspecialista extends EditRecord
{
    protected static string $resource = EspecialistaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
