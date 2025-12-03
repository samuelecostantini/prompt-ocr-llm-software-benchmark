<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Actions\RunExtractionAction;
use App\Filament\Resources\DocumentResource;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractionResult;
use App\Models\GroundTruth;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Document $document */
        $document = parent::handleRecordCreation($data);
        foreach(DetailSet::where('id', $document->detail_set_id)->first()->documentDetails as $detail) {
            GroundTruth::create([
                'document_id' => $document->id,
                'document_detail_id' => $detail->id,
                'value' => '',
            ]);
        }
        return $document;
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

}
