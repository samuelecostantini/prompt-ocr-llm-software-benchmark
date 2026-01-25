<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AwsTextractTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-errors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $promptExCount = \App\Models\Prompt::all()->map(fn ($prompt) => $prompt->extractedFields->count());
        $this->info($promptExCount);
        $max = $promptExCount->max();
        $this->info("Max extracted fields per prompt: $max");
        foreach (\App\Models\Prompt::all() as $prompt) {
            if ($prompt->extractedFields->count() < $max) {
                foreach (range(1, $max - $prompt->extractedFields->count()) as $_) {
                    \App\Models\BenchmarkResult::create([
                        'run_id' => 0,
                        'prompt_id' => $prompt->id,
                        'document_id' => 0,
                        'extracted_field_id' => 0,
                        'detail_name' => 'Gave invalid output',
                        'detail_id' => 0,
                        'extracted_value' => 0,
                        'expected_value' => null,
                        'score' => 0,
                    ]);
                }
            }
        }
    }
}
