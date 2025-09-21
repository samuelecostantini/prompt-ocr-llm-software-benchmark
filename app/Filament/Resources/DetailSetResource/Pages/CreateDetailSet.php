<?php

namespace App\Filament\Resources\DetailSetResource\Pages;

use App\Filament\Resources\DetailSetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDetailSet extends CreateRecord
{
    protected static string $resource = DetailSetResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
