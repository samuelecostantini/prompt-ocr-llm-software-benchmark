<?php

namespace App\Filament\Resources\DetailSetResource\Pages;

use App\Filament\Resources\DetailSetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetailSets extends ListRecords
{
    protected static string $resource = DetailSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
