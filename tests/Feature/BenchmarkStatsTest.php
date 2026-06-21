<?php

use App\Enums\DetailType;
use App\Filament\Pages\BenchmarkStats;
use App\Jobs\BulkRunJob;
use App\Models\BenchmarkResult;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use App\Models\GroundTruth;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

// Guards the BenchmarkStats Filament/Livewire page: the Phase 1 Fix #1
// dispatch path and the cache/reset/re-run behaviour. We drive the page methods
// directly (no HTTP/Livewire lifecycle) to avoid Filament panel auth setup.
beforeEach(function () {
    Cache::forget('benchmark-stats');
    $this->page = new BenchmarkStats;
});

it('dispatches BulkRunJob (Fix #1)', function () {
    Queue::fake();

    $this->page->runBulkExtraction();

    Queue::assertPushed(BulkRunJob::class);
});

it('dispatches BulkRunJob with no arguments — source guard (Fix #1)', function () {
    // BulkRunJob::__construct() takes no args; the job iterates Documents/Prompts
    // internally. Phase 1 removed a spurious `new Run` argument. Modern PHP
    // silently accepts extra constructor args and Queue::fake does not serialize,
    // so a behavioural test cannot distinguish dispatch() from dispatch(new Run)
    // — both run identically. We therefore lock the clean form at the source
    // level, the same way the Textract typo is guarded.
    $source = file_get_contents((new \ReflectionClass(BenchmarkStats::class))->getFileName());

    expect($source)->toContain('BulkRunJob::dispatch();')
        ->and($source)->not->toContain('BulkRunJob::dispatch(new');
});

it('resetBenchData deletes all BenchmarkResult rows and rebuilds the cache fresh', function () {
    BenchmarkResult::factory()->create();
    Cache::put('benchmark-stats', ['stale' => true], now()->addMinutes(10));

    $this->page->resetBenchData();

    // Rows are gone...
    expect(BenchmarkResult::count())->toBe(0)
        // ...and the stale cached value was forgotten + rebuilt by loadData().
        ->and(Cache::get('benchmark-stats'))->not->toBe(['stale' => true])
        ->and(Cache::has('benchmark-stats'))->toBeTrue();
});

it('reRunBenchmark computes results from seeded ExtractedFields and repopulates the cache', function () {
    [$document, $detail] = seedOneExtractableField();

    $this->page->reRunBenchmark();

    expect(BenchmarkResult::count())->toBe(1)
        ->and(BenchmarkResult::first()->extracted_field_id)->not->toBeNull()
        // loadData() runs at the end and repopulates the cache.
        ->and(Cache::has('benchmark-stats'))->toBeTrue();
});

it('loadData caches the benchmark-stats key', function () {
    expect(Cache::has('benchmark-stats'))->toBeFalse();

    $this->page->loadData();

    expect(Cache::has('benchmark-stats'))->toBeTrue();
});

// Helper: build a minimal but coherent extraction chain (User -> DetailSet ->
// Document -> DocumentDetail -> Prompt -> Run -> ExtractedField + GroundTruth)
// so RunBenchmarkAction has something to score.
function seedOneExtractableField(): array
{
    $user = User::factory()->create();
    $detailSet = DetailSet::factory()->create();
    $document = Document::factory()->create(['user_id' => $user->id, 'detail_set_id' => $detailSet->id]);
    $detail = DocumentDetail::factory()->create([
        'name' => 'company',
        'type' => DetailType::String->getValue(),
        'user_id' => $user->id,
        'detail_set_id' => $detailSet->id,
    ]);
    $prompt = Prompt::factory()->create(['user_id' => $user->id]);
    $run = Run::factory()->create(['document_id' => $document->id, 'prompt_id' => $prompt->id]);

    ExtractedField::factory()->create([
        'document_id' => $document->id,
        'document_detail_id' => $detail->id,
        'run_id' => $run->id,
        'value' => 'acme',
    ]);
    GroundTruth::factory()->create([
        'document_id' => $document->id,
        'document_detail_id' => $detail->id,
        'value' => 'acme',
    ]);

    return [$document, $detail];
}
