<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\Prompt;
use App\Models\Run;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BulkRunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        foreach (Document::all() as $document) {

            if ($document->runs()->count() >= Prompt::count()) {
                continue;
            }

            $extracted_text = app(AwsTextractService::class)->textExtractor($document->getFirstMediaPath('document'));

            foreach (Prompt::all() as $prompt) {
                if (! $document->runs()->where('prompt_id', $prompt->id)->exists()) {
                    $run = Run::create([
                        'document_id' => $document->id,
                        'prompt_id' => $prompt->id,
                    ]);

                    Log::channel('extraction')->info('starting extraction of document id: '.$document->id);
                    Log::channel('extraction')->info('document at path: '.$document->getFirstMediaPath('document'));

                    $structured_result = app(OpenAIService::class)->readInvoice($extracted_text, $document, $prompt);

                    Log::channel('extraction')->info('$structured_result: '.json_encode($structured_result, JSON_PRETTY_PRINT));

                    foreach ($structured_result as $key => $result) {
                        // Scope to the document's DetailSet so a shared field
                        // name in another set can't be matched by accident.
                        $detail = DocumentDetail::query()
                            ->where('detail_set_id', $document->detail_set_id)
                            ->where('name', $key)
                            ->first();
                        if ($detail !== null) {
                            $document->extractedFields()->create([
                                'document_detail_id' => $detail->id,
                                'run_id' => $run->id,
                                'value' => $result,
                            ]);
                        }
                    }

                    Log::channel('extraction')->info('extraction ended.');
                    Log::channel('extraction')->info('___________________________________________________________________');
                    Log::channel('extraction')->info('___________________________________________________________________');

                }
            }
        }
    }
}
