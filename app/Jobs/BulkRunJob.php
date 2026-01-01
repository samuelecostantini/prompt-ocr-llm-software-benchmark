<?php

namespace App\Jobs;

use App\Actions\RunExtractionAction;
use App\Models\Document;
use App\Models\Prompt;
use App\Models\Run;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DocumentDetail;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;

class BulkRunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        foreach (Document::all() as $document) {
            
            if($document->runs()->count() >= Prompt::count()) {
                continue;
            }

            $extracted_text = app(AwsTextractService::class)->textExtractor($document->getFirstMediaPath('document'));
            
            foreach (Prompt::all() as $prompt) {
                if(!$document->runs()->where('prompt_id', $prompt->id)->exists()) {
                    $run = Run::create([
                        'document_id' => $document->id,
                        'prompt_id' => $prompt->id,
                    ]);
        
                    Log::channel('extraction')->info('starting extraction of document id: '.$document->id);
                    Log::channel('extraction')->info('document at path: '.$document->getFirstMediaPath('document'));

                    $structured_result = app(OpenAIService::class)->readInvoice($extracted_text, $document, $prompt);

                    Log::channel('extraction')->info('$structured_result: '.json_encode($structured_result, JSON_PRETTY_PRINT));

                    foreach ($structured_result as $key => $result) {
                        if (DocumentDetail::whereName($key)->first() !== null) {
                            $document_detail_id = DocumentDetail::whereName($key)->first()->id;
                            $document->extractedFields()->create([
                                'document_detail_id' => $document_detail_id,
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
