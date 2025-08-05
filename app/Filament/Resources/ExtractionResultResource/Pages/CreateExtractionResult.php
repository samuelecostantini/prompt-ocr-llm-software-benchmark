<?php

namespace App\Filament\Resources\ExtractionResultResource\Pages;

use App\Filament\Resources\ExtractionResultResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExtractionResult extends CreateRecord
{
    protected static string $resource = ExtractionResultResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
