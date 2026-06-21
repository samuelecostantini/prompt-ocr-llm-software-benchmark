<?php

use App\Actions\RunBenchmarkAction;
use App\Enums\DetailType;
use App\Models\BenchmarkResult;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use App\Models\GroundTruth;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

// Regression guard for Phase 1 Fix #3: RunBenchmarkAction must be idempotent
// (updateOrCreate keyed on extracted_field_id), and the benchmark_results
// table must enforce a unique index on extracted_field_id.
beforeEach(function () {
    $this->user = User::factory()->create();
    $this->detailSet = DetailSet::factory()->create();
    $this->prompt = Prompt::factory()->create(['user_id' => $this->user->id]);
    $this->document = Document::factory()->create([
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);

    // Two details: a String (perfect match) and a Number (mismatch -> score 0).
    $this->detailString = DocumentDetail::factory()->create([
        'name' => 'company',
        'type' => DetailType::String->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
    $this->detailNumber = DocumentDetail::factory()->create([
        'name' => 'amount',
        'type' => DetailType::Number->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);

    $this->run = Run::factory()->create([
        'document_id' => $this->document->id,
        'prompt_id' => $this->prompt->id,
    ]);

    $this->efString = ExtractedField::factory()->create([
        'document_id' => $this->document->id,
        'document_detail_id' => $this->detailString->id,
        'run_id' => $this->run->id,
        'value' => 'acme',
    ]);
    $this->efNumber = ExtractedField::factory()->create([
        'document_id' => $this->document->id,
        'document_detail_id' => $this->detailNumber->id,
        'run_id' => $this->run->id,
        'value' => '100',
    ]);

    GroundTruth::factory()->create([
        'document_id' => $this->document->id,
        'document_detail_id' => $this->detailString->id,
        'value' => 'acme',
    ]);
    GroundTruth::factory()->create([
        'document_id' => $this->document->id,
        'document_detail_id' => $this->detailNumber->id,
        'value' => '90', // diff 10 -> clamped to 0.0
    ]);

    // Clear any cached stats so assertions read fresh from the DB.
    Cache::forget('benchmark-stats');
});

it('creates one BenchmarkResult per ExtractedField with the correct score', function () {
    RunBenchmarkAction::handle();

    expect(BenchmarkResult::count())->toBe(2);

    $stringResult = BenchmarkResult::where('extracted_field_id', $this->efString->id)->first();
    $numberResult = BenchmarkResult::where('extracted_field_id', $this->efNumber->id)->first();

    expect($stringResult)->not->toBeNull()
        ->and((float) $stringResult->score)->toBe(1.0)
        ->and($stringResult->expected_value)->toBe('acme')
        ->and($stringResult->extracted_value)->toBe('acme')
        ->and($numberResult)->not->toBeNull()
        ->and((float) $numberResult->score)->toBe(0.0)
        ->and($numberResult->expected_value)->toBe('90')
        ->and($numberResult->extracted_value)->toBe('100');
});

it('is idempotent: re-running does not duplicate BenchmarkResult rows', function () {
    RunBenchmarkAction::handle();
    $countAfterFirst = BenchmarkResult::count();

    RunBenchmarkAction::handle();
    $countAfterSecond = BenchmarkResult::count();

    // The core Fix #3 guard: no duplicates on re-run.
    expect($countAfterSecond)->toBe($countAfterFirst)
        ->and($countAfterSecond)->toBe(2);
});

it('updates scores in place on re-run rather than creating new rows', function () {
    RunBenchmarkAction::handle();

    // Change the ground truth so the score should change on re-run.
    GroundTruth::where('document_detail_id', $this->detailNumber->id)->update(['value' => '100']);

    RunBenchmarkAction::handle();

    $numberResult = BenchmarkResult::where('extracted_field_id', $this->efNumber->id)->first();

    // Still exactly one row, now scored 1.0 (100 vs 100).
    expect(BenchmarkResult::where('extracted_field_id', $this->efNumber->id)->count())->toBe(1)
        ->and((float) $numberResult->score)->toBe(1.0);
});

it('enforces a unique index on extracted_field_id', function () {
    RunBenchmarkAction::handle(); // creates the result for efString

    // A direct second insert with the same extracted_field_id must violate the
    // unique constraint added in migration 2026_06_21_124629.
    expect(fn () => BenchmarkResult::factory()->create([
        'extracted_field_id' => $this->efString->id,
    ]))->toThrow(QueryException::class);
});

it('throws when an ExtractedField has no matching GroundTruth (characterization)', function () {
    // Known edge-case bug: expected_value comes from GroundTruth (nullable at
    // the query level) but the benchmark_results.expected_value column is NOT
    // NULL, so a missing GroundTruth crashes the whole benchmark run.
    // TODO Phase 2: handle null expected_value (coerce to '' or skip) and flip
    // this test to assert a graceful 0.0-scored row instead of a throw.
    GroundTruth::where('document_detail_id', $this->detailNumber->id)->delete();

    expect(fn () => RunBenchmarkAction::handle())->toThrow(QueryException::class);
});
