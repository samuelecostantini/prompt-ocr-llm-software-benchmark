<?php

namespace App\Filament\Resources\DetailSetResource\Pages;

use App\Filament\Resources\DetailSetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDetailSet extends EditRecord
{
    protected static string $resource = DetailSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
