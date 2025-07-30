<?php

namespace App\Filament\Resources\DocumentDetailResource\Pages;

use App\Filament\Resources\DocumentDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentDetail extends EditRecord
{
    protected static string $resource = DocumentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
