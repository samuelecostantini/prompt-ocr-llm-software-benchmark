<?php

namespace App\Actions;

use App\Facades\Evaluation;
use App\Models\BenchmarkResult;
use App\Models\ExtractedField;
use App\Models\GroundTruth;
use Illuminate\Database\Eloquent\Collection;

class RunBenchmarkAction
{
    public static function handle(): void
    {
        ExtractedField::with(['documentDetail', 'run'])->chunkById(200, function (Collection $extractedFields) {
            foreach ($extractedFields as $extractedField) {
                /** @var ExtractedField $extractedField */
                $expectedValue = GroundTruth::query()
                    ->where('document_id', $extractedField->document_id)
                    ->where('document_detail_id', $extractedField->document_detail_id)
                    ->first()?->value;

                $extractedValue = $extractedField->value;

                $score = Evaluation::computeScore(
                    $extractedValue,
                    $expectedValue,
                    $extractedField->documentDetail?->type ?? ''
                );

                BenchmarkResult::updateOrCreate(
                    ['extracted_field_id' => $extractedField->id],
                    [
                        'run_id' => $extractedField->run_id,
                        'prompt_id' => $extractedField->run?->prompt_id,
                        'document_id' => $extractedField->document_id,
                        'extracted_field_id' => $extractedField->id,
                        'detail_name' => $extractedField->documentDetail?->name ?? '',
                        'detail_id' => $extractedField->document_detail_id,
                        'extracted_value' => $extractedValue,
                        'expected_value' => $expectedValue,
                        'score' => $score,
                    ]
                );
            }
        });
    }
}
