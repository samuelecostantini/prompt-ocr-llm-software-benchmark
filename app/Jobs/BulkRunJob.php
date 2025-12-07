<?php

namespace App\Jobs;

use App\Actions\RunExtractionAction;
use App\Models\Document;
use App\Models\Prompt;
use App\Models\Run;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkRunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Run $run)
    {
    }

    public function handle(): void
    {
        foreach (Prompt::all() as $prompt) {
            foreach (Document::all() as $document) {
                RunExtractionAction::
            }
        }
    }
}
