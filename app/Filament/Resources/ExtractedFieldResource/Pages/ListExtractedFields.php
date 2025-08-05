<?php

namespace App\Filament\Resources\ExtractedFieldResource\Pages;

use App\Filament\Resources\ExtractedFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtractedFields extends ListRecords
{
    protected static string $resource = ExtractedFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
