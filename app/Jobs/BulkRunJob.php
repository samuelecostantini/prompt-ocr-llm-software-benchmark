<?php

namespace App\Jobs;

use App\Actions\RunExtractionAction;
use App\Models\Document;
use App\Models\Prompt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkRunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        foreach (Prompt::all() as $prompt) {
            foreach (Document::all() as $document) {
                if(!$document->runs()->where('prompt_id', $prompt->id)->exists()) {
                    (new RunExtractionAction)->handle($document, $prompt);
                }
            }
        }
    }
}
