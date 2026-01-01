<?php

namespace App\Services;

use App\Enums\DetailType;
use Carbon\Carbon;

class EvaluationService
{
    public function __construct() {}

    public function computeScore(string $extractedValue, ?string $expectedValue, string $detailType): float
    {
        if($expectedValue === null){
            if($extractedValue === null 
                || $extractedValue === ''
                || $extractedValue === '0' 
                || $extractedValue === 0
            ){ 
                return 1.0; 
            } else{
                return 0.0; 
            }
        }
                
        return match ($detailType) {
            DetailType::String->getValue() => $this->compareStringsWithJaccard($extractedValue, $expectedValue),
            DetailType::Number->getValue() => $this->compareNumbers($extractedValue, $expectedValue),
            DetailType::Date->getValue() => $this->compareDates($extractedValue, $expectedValue),
            default => 0.0
        };
    }

    protected function compareNumbers(string $extractedValue, string $expectedValue)
    {
        $cleanedExtracted = preg_replace('/[^\d.,]/', '', $extractedValue);
        $cleanedExpected = preg_replace('/[^\d.,]/', '', $expectedValue);

        $floatEx = (float) str_replace(',', '.', $cleanedExtracted);
        $floatExp = (float) str_replace(',', '.', $cleanedExpected);

        if (abs($floatEx - $floatExp) < 0.01) {
            return 1.0;
        }

        return 0.0;
    }

    protected function compareDates(string $extractedValue, string $expectedValue)
    {
        $extractedValue = str_replace(['-', '.'], '/', $extractedValue);
        $expectedValue = str_replace(['-', '.'], '/', $expectedValue);

        try {
            $dateEx = Carbon::createFromFormat('d/m/Y', $extractedValue);
            $dateExp = Carbon::createFromFormat('d/m/Y', $expectedValue);
        } catch (\Exception $e) {
            try {
                $dateEx = Carbon::createFromFormat('Y/m/d', $extractedValue);
                $dateExp = Carbon::createFromFormat('Y/m/d', $expectedValue);
            } catch (\Exception $e) {
                try {
                    $dateEx = Carbon::createFromFormat('m/d/Y', $extractedValue);
                    $dateExp = Carbon::createFromFormat('m/d/Y', $expectedValue);
                } catch (\Exception $e) {
                    return $this->compareStringsWithJaccard($extractedValue, $expectedValue);
                }
            }
        }

        return $dateEx->eq($dateExp) ? 1.0 : 0.0;
    }

    protected function compareStringsWithJaccard(string $extractedValue, string $expectedValue)
    {
        return similar_text(strtolower($extractedValue), strtolower($expectedValue), $percent) ? $percent / 100 : 0.0;
    }
}
