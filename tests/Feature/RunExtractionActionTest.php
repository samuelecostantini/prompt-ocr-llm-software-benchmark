<?php

use App\Actions\RunExtractionAction;
use App\Enums\DetailType;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use Tests\Support\BindsFakes;

// Guards the synchronous extraction orchestration in RunExtractionAction.
uses(BindsFakes::class);

beforeEach(function () {
    $this->setUpBindsFakes();

    $this->user = User::factory()->create();
    $this->detailSet = DetailSet::factory()->create();
    $this->document = Document::factory()->create([
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
    $this->prompt = Prompt::factory()->create(['user_id' => $this->user->id]);

    $this->detailCompany = DocumentDetail::factory()->create([
        'name' => 'company',
        'type' => DetailType::String->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
    $this->detailAmount = DocumentDetail::factory()->create([
        'name' => 'amount',
        'type' => DetailType::Number->getValue(),
        'user_id' => $this->user->id,
        'detail_set_id' => $this->detailSet->id,
    ]);
});

it('creates a Run and one ExtractedField per detail returned by the AI', function () {
    app(RunExtractionAction::class)->handle($this->document, $this->prompt);

    expect(Run::count())->toBe(1)
        ->and(ExtractedField::count())->toBe(2)
        ->and($this->fakeOcr()->calls)->toHaveCount(1)
        ->and($this->fakeAi()->calls)->toHaveCount(1);

    // ExtractedFields are linked to the created run and the right details.
    $run = Run::first();
    $byDetail = ExtractedField::where('run_id', $run->id)->get()->keyBy('document_detail_id');

    expect($byDetail->get($this->detailCompany->id)->value)->toBe('extracted-company')
        ->and($byDetail->get($this->detailAmount->id)->value)->toBe('extracted-amount');
});

it('throws when the AI returns a key with no matching DocumentDetail (characterization)', function () {
    // Known bug: RunExtractionAction does not null-guard
    // DocumentDetail::whereName($key)->first() (unlike BulkRunJob which does).
    // With an unknown key, first() returns null -> `->id` on null emits a
    // warning that Laravel's error handler converts to an ErrorException.
    // TODO Phase 2: add the null guard (skip unknown keys, as BulkRunJob does)
    // and flip this test to assert the unknown key is ignored, not thrown on.
    $this->fakeAi()->withUnknownKey = true;

    expect(fn () => app(RunExtractionAction::class)->handle($this->document, $this->prompt))
        ->toThrow(\ErrorException::class);
});
