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
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;


    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label('Inizia estrazione')
            ->submit('create')
            ->keyBindings(['mod+s']);
    }
    protected function getHeaderActions(): array
    {
        return [

        ];
    }
    protected function afterCreate(): void{
        /**
         * @var Document $record
         */

        $record = $this->getRecord();
        $document = Document::find($record->id);
        $newExtraction = new RunExtractionAction();
        $newExtraction->handle($document);

    }
}
