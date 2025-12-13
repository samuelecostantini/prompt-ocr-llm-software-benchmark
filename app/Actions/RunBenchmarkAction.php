<?php

namespace App\Actions;

use App\Facades\Evaluation;
use App\Models\BenchmarkResult;
use App\Models\Document;
use App\Models\Run;

class RunBenchmarkAction
{
    public static function handle()
    {
        foreach (Document::all() as $document) {
            foreach (Run::all() as $run) {
                foreach ($run->extractedFields as $extractedField) {

                    $groundThrut = $document->groundTruths()->where('document_detail_id', $extractedField->document_detail_id)->first();

                    $score = Evaluation::computeScore($extractedField->value, $groundThrut ? $groundThrut->value : '', $extractedField?->document_detail?->type? : '');

                    $groundThrut = $document->groundTruths()->where('document_detail_id', $extractedField->document_detail_id)->first();
                    BenchmarkResult::create([
                        'run_id' => $run->id,
                        'extracted_field_id' => $extractedField->document_detail_id,
                        'extracted_value' => $extractedField->value,
                        'expected_value' => $groundThrut ? $groundThrut->value : '',
                        'score' => $score,
                    ]);
                }
            }
        }
    }

    public function calculateScore($extractedValue, $expectedValue)
    {
        $extractedValue = trim(strtolower($extractedValue));
        $expectedValue = trim(strtolower($expectedValue));

        if ($extractedValue === $expectedValue) {
            return 1.0; // Perfect match
        }

        similar_text($extractedValue, $expectedValue, $percent);

        return $percent / 100;
    }
}
