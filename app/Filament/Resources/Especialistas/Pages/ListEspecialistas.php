<?php

namespace App\Filament\Resources\Especialistas\Pages;

use App\Filament\Resources\Especialistas\EspecialistaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEspecialistas extends ListRecords
{
    protected static string $resource = EspecialistaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
