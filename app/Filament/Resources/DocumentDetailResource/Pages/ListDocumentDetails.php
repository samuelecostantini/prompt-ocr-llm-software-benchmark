<?php

namespace App\Filament\Resources\DocumentDetailResource\Pages;

use App\Filament\Resources\DocumentDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentDetails extends ListRecords
{
    protected static string $resource = DocumentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
