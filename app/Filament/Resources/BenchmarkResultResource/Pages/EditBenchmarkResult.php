<?php

namespace App\Filament\Resources\BenchmarkResultResource\Pages;

use App\Filament\Resources\BenchmarkResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBenchmarkResult extends EditRecord
{
    protected static string $resource = BenchmarkResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
