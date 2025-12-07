<?php

namespace App\Services;

use App\Enums\DetailType;
use Carbon\Carbon;

class EvaluationService
{
    public function __construct() {}

    public function computeScore(string $extractedValue, string $expectedValue, string $detailType): float
    {

        return match ($detailType) {
            DetailType::String->getValue() => $this->compareStringsWithJaccard($extractedValue, $expectedValue),
            DetailType::Number->getValue() => $this->compareNumbers($extractedValue, $expectedValue),
            DetailType::Date->getValue() => $this->compareDates($extractedValue, $expectedValue),
            default => 0.0,
        };
    }

    protected function compareNumbers(string $extractedValue, string $expectedValue)
    {
        $cleanedExtracted = preg_replace('/[^\d.]/', '', $extractedValue);
        $cleanedExpected = preg_replace('/[^\d.]/', '', $expectedValue);

        $floatEx = (float) str_replace(',', '.', $cleanedExtracted);
        $floatExp = (float) str_replace(',', '.', $cleanedExpected);

        if (abs($floatEx - $floatExp) < 0.01) {
            return 1.0; // Perfect match
        }

        return 0.0; // No match
    }

    protected function compareDates(string $extractedValue, string $expectedValue)
    {
        try {
            $dateEx = Carbon::parse($extractedValue);
            $dateExp = Carbon::parse($expectedValue);

            return $dateEx->equalTo($dateExp) ? 1.0 : 0.0;
        } catch (\Exception $e) {
            return 0.0; // Parsing failed, no match
        }
    }

    protected function compareStringsWithJaccard(string $extractedValue, string $expectedValue)
    {
        /*$exWords = explode(' ', strtolower($extractedValue));
        $expWords = explode(' ', strtolower($expectedValue));

        $intersection = array_intersect($exWords, $expWords);
        $union = array_unique(array_merge($exWords, $expWords));

        if (count($union) === 0) {
            return 1.0; // Both strings are empty
        }

        return count($intersection) / count($union); */
        return similar_text(strtolower($extractedValue), strtolower($expectedValue), $percent) ? $percent / 100 : 0.0;
    }

    protected function compareStringWithLevenshtein(string $extractedValue, string $expectedValue)
    {
        // TODO: to implement
        return 0.0;
        $distance = levenshtein(strtolower($extractedValue), strtolower($expectedValue));
        $maxLen = max(strlen($extractedValue), strlen($expectedValue));

        if ($maxLen === 0) {
            return 1.0; // Both strings are empty
        }

        return 1.0 - ($distance / $maxLen);

    }
}
