<?php

namespace App\Actions;

use App\Facades\Evaluation;
use App\Models\BenchmarkResult;
use App\Models\Document;
use App\Models\ExtractedField;
use App\Models\GroundTruth;
use App\Models\Run;

class RunBenchmarkAction
{
    public static function handle(): void
    {
        foreach (ExtractedField::all() as $extractedField){
            /** @var ExtractedField $extractedField */
        
            $expectedValue = $extractedField->document->groundTruths->where('document_detail_id', $extractedField->document_detail_id)->first()?->value? : null;
          
            $extractedValue = $extractedField->value;

            $score = Evaluation::computeScore(
                $extractedValue,
                $expectedValue,
                $extractedField->documentDetail?->type ?? ''
            );

            BenchmarkResult::create([
                'run_id' => $extractedField->run_id,
                'prompt_id' => $extractedField->run?->prompt_id? : 0,
                'document_id' => $extractedField->document_id,
                'extracted_field_id' => $extractedField->id,
                'detail_name' => $extractedField->documentDetail->name ?? '',
                'detail_id' => $extractedField->document_detail_id,
                'extracted_value' => $extractedValue,
                'expected_value' => $expectedValue,
                'score' => $score,
            ]);
        }
    }

}
