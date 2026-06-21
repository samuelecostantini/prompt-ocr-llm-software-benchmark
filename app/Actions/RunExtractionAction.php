<?php

namespace App\Actions;

use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\Prompt;
use App\Models\Run;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;

class RunExtractionAction
{
    public function handle(Document $document, Prompt $prompt): void
    {

        $run = Run::create([
            'document_id' => $document->id,
            'prompt_id' => $prompt->id,
        ]);

        Log::channel('extraction')->info('starting extraction of document id: '.$document->id);
        Log::channel('extraction')->info('document at path: '.$document->getFirstMediaPath('document'));

        $extracted_text = app(AwsTextractService::class)->textExtractor($document->getFirstMediaPath('document'));
        $structured_result = app(OpenAIService::class)->readInvoice($extracted_text, $document, $prompt);

        Log::channel('extraction')->info('$structured_result: '.json_encode($structured_result, JSON_PRETTY_PRINT));

        foreach ($structured_result as $key => $result) {
            // Scope to the document's DetailSet so a shared field name in
            // another set (e.g. "total", "date") can't be matched by accident.
            $document_detail_id = DocumentDetail::query()
                ->where('detail_set_id', $document->detail_set_id)
                ->where('name', $key)
                ->first()->id;
            $document->extractedFields()->create([
                'document_detail_id' => $document_detail_id,
                'run_id' => $run->id,
                'value' => $result,
            ]);
        }

        Log::channel('extraction')->info('extraction ended.');
        Log::channel('extraction')->info('___________________________________________________________________');
        Log::channel('extraction')->info('___________________________________________________________________');

    }
}
