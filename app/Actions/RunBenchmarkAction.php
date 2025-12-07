<?php

namespace App\Actions;

use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractionResult;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use App\Models\ExtractedField;
use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;

class RunBenchmarkAction
{
    public static function handle(): void
    {
        foreach (Run::all() as $run) {
            Log::channel('benchmark')->info('starting benchmark of run id: '.$run->id);

            $extracted_fields = ExtractedField::where('run_id', $run->id)->get();
            $ground_truth_fields = $run->document->groundTruths;

            $total_fields = count($ground_truth_fields);
            $correct_fields = 0;

            foreach ($ground_truth_fields as $ground_truth_field) {
                $extracted_field = $extracted_fields->firstWhere('document_detail_id', $ground_truth_field->document_detail_id);
                if ($extracted_field && $extracted_field->value === $ground_truth_field->value) {
                    $correct_fields++;
                }
            }

            $accuracy = $total_fields > 0 ? ($correct_fields / $total_fields) * 100 : 0;

            Log::channel('benchmark')->info('Run ID: '.$run->id.' - Accuracy: '.number_format($accuracy, 2).'% ('.$correct_fields.'/'.$total_fields.')');

            \App\Models\BenchmarkResult::create([
                'run_id' => $run->id,
                'accuracy' => $accuracy,
                'total_fields' => $total_fields,
                'correct_fields' => $correct_fields,
            ]);

            Log::channel('benchmark')->info('benchmark ended for run id: '.$run->id);
            Log::channel('benchmark')->info('___________________________________________________________________');
            Log::channel('benchmark')->info('___________________________________________________________________');
        }
    }
}
