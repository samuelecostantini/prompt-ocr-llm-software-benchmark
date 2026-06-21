<?php

use App\Enums\DetailType;
use App\Jobs\BulkRunJob;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use Tests\Support\BindsFakes;

// Regression guard for Phase 1 Fix #1 and the bulk-extraction orchestration:
// - BulkRunJob takes no constructor args and dispatches cleanly (Fix #1).
// - Textract runs once per document; OpenAI runs once per (document, prompt).
// - Re-dispatching is idempotent (existing runs are skipped).
uses(BindsFakes::class);

beforeEach(function () {
    $this->setUpBindsFakes();

    $this->user = User::factory()->create();
    $this->detailSet = DetailSet::factory()->create();
    $this->promptA = Prompt::factory()->create(['user_id' => $this->user->id]);
    $this->promptB = Prompt::factory()->create(['user_id' => $this->user->id]);

    DocumentDetail::factory()->create([
        'name' => 'company',
        'type' => DetailType::String->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
    DocumentDetail::factory()->create([
        'name' => 'amount',
        'type' => DetailType::Number->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);

    $this->docA = Document::factory()->create([
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
    $this->docB = Document::factory()->create([
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
});

it('constructs with no constructor args (Fix #1)', function () {
    // BulkRunJob::__construct() takes no parameters. Constructing it directly
    // must not throw — guards against re-introducing dispatch(new Run).
    expect(new BulkRunJob)->toBeInstanceOf(BulkRunJob::class);
});

it('runs Textract once per document and OpenAI once per document+prompt', function () {
    BulkRunJob::dispatch();

    // 2 documents -> Textract called twice (once per doc, reused across prompts).
    expect($this->fakeOcr()->calls)->toHaveCount(2);
    // 2 documents x 2 prompts -> OpenAI called 4 times.
    expect($this->fakeAi()->calls)->toHaveCount(4);

    // A Run per (document, prompt) pair = 4.
    expect(Run::count())->toBe(4);
    // Each run produces 2 ExtractedFields (company + amount) = 8.
    expect(ExtractedField::count())->toBe(8);
});

it('creates Runs and ExtractedFields linked to the right prompt and document', function () {
    BulkRunJob::dispatch();

    $runA1 = Run::where('document_id', $this->docA->id)->where('prompt_id', $this->promptA->id)->first();
    $runB2 = Run::where('document_id', $this->docB->id)->where('prompt_id', $this->promptB->id)->first();

    expect($runA1)->not->toBeNull()
        ->and($runB2)->not->toBeNull();

    // ExtractedFields for doc A + prompt A run are attached to that run.
    $fieldsForRunA1 = ExtractedField::where('run_id', $runA1->id)->pluck('value')->all();
    expect($fieldsForRunA1)
        ->toContain('extracted-company')
        ->and($fieldsForRunA1)->toContain('extracted-amount');
});

it('is idempotent: re-dispatching does not duplicate runs or re-call the providers', function () {
    BulkRunJob::dispatch();
    $ocrCallsAfterFirst = count($this->fakeOcr()->calls);
    $aiCallsAfterFirst = count($this->fakeAi()->calls);

    BulkRunJob::dispatch();

    // Each document already has runs for all prompts -> skipped before Textract.
    expect(count($this->fakeOcr()->calls))->toBe($ocrCallsAfterFirst)
        ->and(count($this->fakeAi()->calls))->toBe($aiCallsAfterFirst)
        ->and(Run::count())->toBe(4)
        ->and(ExtractedField::count())->toBe(8);
});

it('skips a prompt that already has a run for a given document', function () {
    // Pre-create a run for docA + promptA so only promptB should run for docA.
    Run::factory()->create([
        'document_id' => $this->docA->id,
        'prompt_id' => $this->promptA->id,
    ]);

    BulkRunJob::dispatch();

    // docA gets only the promptB run (promptA already existed); docB gets both.
    expect(Run::where('document_id', $this->docA->id)->count())->toBe(2)
        ->and(Run::where('document_id', $this->docB->id)->count())->toBe(2);
});
