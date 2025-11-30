<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Actions\RunExtractionAction;
use App\Filament\Resources\DocumentResource;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractionResult;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

}
