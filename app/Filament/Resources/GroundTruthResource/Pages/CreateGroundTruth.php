<?php

namespace App\Filament\Resources\GroundTruthResource\Pages;

use App\Filament\Resources\GroundTruthResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroundTruth extends CreateRecord
{
    protected static string $resource = GroundTruthResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
