<?php

namespace App\Filament\Resources\GroundTruthResource\Pages;

use App\Filament\Resources\GroundTruthResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGroundTruth extends EditRecord
{
    protected static string $resource = GroundTruthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
