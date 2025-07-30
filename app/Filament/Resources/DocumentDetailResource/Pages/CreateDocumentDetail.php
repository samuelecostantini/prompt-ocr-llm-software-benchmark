<?php

namespace App\Filament\Resources\DocumentDetailResource\Pages;

use App\Filament\Resources\DocumentDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentDetail extends CreateRecord
{
    protected static string $resource = DocumentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
