<?php

namespace App\Filament\Resources\ExtractedFieldResource\Pages;

use App\Filament\Resources\ExtractedFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtractedField extends EditRecord
{
    protected static string $resource = ExtractedFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
