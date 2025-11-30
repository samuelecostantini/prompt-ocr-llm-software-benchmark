<?php

namespace App\Filament\Resources\GroundTruthResource\Pages;

use App\Filament\Resources\GroundTruthResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroundTruths extends ListRecords
{
    protected static string $resource = GroundTruthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
