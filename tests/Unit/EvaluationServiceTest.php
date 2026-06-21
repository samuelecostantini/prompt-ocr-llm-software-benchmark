<?php

use App\Enums\DetailType;
use App\Services\EvaluationService;
use Illuminate\Support\Facades\Log;

// Boot the Laravel app for this file: EvaluationService calls the root `Log`
// facade alias (registered only when the app is booted) and we silence it with
// Log::spy(). No DB is touched, so no RefreshDatabase.
uses(\Tests\TestCase::class);

beforeEach(function () {
    Log::spy();
    $this->service = new EvaluationService;
});

it('returns 1.0 when expected is null and extracted is empty/zero', function (mixed $extracted) {
    expect($this->service->computeScore($extracted, null, DetailType::String->getValue()))
        ->toBe(1.0);
})->with([
    'null' => null,
    'empty string' => '',
    'string zero' => '0',
    'int zero' => 0,
]);

it('returns 0.0 when expected is null but extracted has a value', function () {
    expect($this->service->computeScore('something', null, DetailType::String->getValue()))
        ->toBe(0.0);
});

it('scores identical strings as a perfect 1.0 (case-insensitive)', function () {
    expect($this->service->computeScore('Invoice', 'invoice', DetailType::String->getValue()))
        ->toBe(1.0);
    expect($this->service->computeScore('ABC', 'ABC', DetailType::String->getValue()))
        ->toBe(1.0);
});

it('scores zero for strings with no overlap', function () {
    // similar_text returns 0 matching chars -> ternary yields 0.0
    expect($this->service->computeScore('abc', 'xyz', DetailType::String->getValue()))
        ->toBe(0.0);
});

it('scores partial string matches between 0 and 1 (similar_text based)', function () {
    $score = $this->service->computeScore('abc', 'abd', DetailType::String->getValue());

    expect($score)->toBeGreaterThan(0.0)
        ->toBeLessThan(1.0);
});

it('scores numbers exactly when they match', function () {
    expect($this->service->computeScore('100', '100', DetailType::Number->getValue()))
        ->toBe(1.0);
});

it('normalizes comma decimals and surrounding symbols for numbers', function () {
    // "1,5" and "1.5" both parse to 1.5 -> perfect score
    expect($this->service->computeScore('1,5', '1.5', DetailType::Number->getValue()))
        ->toBe(1.0);
    // "€ 100" stripped to "100" -> perfect score
    expect($this->service->computeScore('€ 100', '100', DetailType::Number->getValue()))
        ->toBe(1.0);
});

it('clamps number scores to 0 when the difference exceeds 1', function () {
    // diff = 10 -> 1 - 10 = -9 -> clamped to 0.0
    expect($this->service->computeScore('100', '90', DetailType::Number->getValue()))
        ->toBe(0.0);
});

it('scores proportional to numeric proximity', function () {
    // diff = 0.5 -> score = 0.5
    expect($this->service->computeScore('100', '100,5', DetailType::Number->getValue()))
        ->toBe(0.5);
});

it('scores identical d/m/Y dates as 1.0', function () {
    expect($this->service->computeScore('01/12/2023', '01/12/2023', DetailType::Date->getValue()))
        ->toBe(1.0);
});

it('scores different d/m/Y dates as 0.0', function () {
    expect($this->service->computeScore('01/12/2023', '02/12/2023', DetailType::Date->getValue()))
        ->toBe(0.0);
});

it('normalizes dashes and dots to slashes before parsing dates', function () {
    // "2023-12-01" -> "2023/12/01" (Y/m/d) == "2023/12/01"
    expect($this->service->computeScore('2023-12-01', '2023/12/01', DetailType::Date->getValue()))
        ->toBe(1.0);
});

it('parses Y/m/d dates', function () {
    expect($this->service->computeScore('2023/12/01', '2023/12/01', DetailType::Date->getValue()))
        ->toBe(1.0);
});

it('falls back to string similarity for unparseable date inputs', function () {
    // No format parses "notadate" -> compareStringsWithJaccard -> identical -> 1.0
    expect($this->service->computeScore('notadate', 'notadate', DetailType::Date->getValue()))
        ->toBe(1.0);
});

it('returns 0.0 for an unknown detail type', function () {
    expect($this->service->computeScore('foo', 'foo', 'boolean'))
        ->toBe(0.0);
});
