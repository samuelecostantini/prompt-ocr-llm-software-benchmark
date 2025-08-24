<?php

namespace App\Filament\Resources\DocumentResource\Pages;

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

        $extracted_text = app(AwsTextractService::class)->textExtractor($document->getFirstMediaPath('document'));
        //$structured_result = app(OpenAIService::class)->readInvoiceFromImg($document);
        $structured_result = app(OpenAIService::class)->readInvoice($extracted_text, auth()->user());

        foreach ($structured_result as $key => $result) {

            $document_detail_id = DocumentDetail::whereName($key)->first()->id;
            $document->extractedFields()->create([
                'document_detail_id' => $document_detail_id,
                'value' => $result,
            ]);
        }

    }
}
