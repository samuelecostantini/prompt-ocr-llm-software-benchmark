<?php

use App\Enums\DetailType;
use App\Models\DetailSet;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Services\DetailSchemaService;
use Illuminate\Database\Eloquent\Model;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

// Unit test for DetailSchemaService::generate(). The service has no injected
// dependencies, so we instantiate it directly and build an in-memory Document
// with relations attached via setRelation() — no DB, no app, no facade.
// Model::unguarded() is needed because Laravel's default $guarded is ['*'].
beforeEach(function () {
    $this->details = Model::unguarded(fn () => collect([
        new DocumentDetail(['name' => 'name_field', 'type' => DetailType::String->getValue(), 'additional_info_for_prompt' => 'The full name']),
        new DocumentDetail(['name' => 'amount', 'type' => DetailType::Number->getValue(), 'additional_info_for_prompt' => 'Total amount']),
        new DocumentDetail(['name' => 'date_field', 'type' => DetailType::Date->getValue(), 'additional_info_for_prompt' => 'Issue date']),
    ]));

    $detailSet = new DetailSet;
    $detailSet->setRelation('documentDetails', $this->details);

    $this->document = new Document;
    $this->document->setRelation('detailSet', $detailSet);

    $this->service = new DetailSchemaService;
});

it('returns an ObjectSchema named "document"', function () {
    $schema = $this->service->generate($this->document);

    expect($schema)->toBeInstanceOf(ObjectSchema::class)
        ->and($schema->name)->toBe('document')
        ->and($schema->description)->toBe('Document Schema');
});

it('creates one schema property per document detail', function () {
    expect($this->service->generate($this->document)->properties)->toHaveCount(3);
});

it('uses StringSchema for String details', function () {
    $props = collect($this->service->generate($this->document)->properties)
        ->keyBy(fn ($s) => $s->name);

    expect($props->get('name_field'))->toBeInstanceOf(StringSchema::class)
        ->and($props->get('name_field')->description)->toBe('The full name');
});

it('uses NumberSchema for Number details', function () {
    $props = collect($this->service->generate($this->document)->properties)
        ->keyBy(fn ($s) => $s->name);

    expect($props->get('amount'))->toBeInstanceOf(NumberSchema::class);
});

it('uses StringSchema for Date details and appends the dd/mm/yyyy conversion note', function () {
    $props = collect($this->service->generate($this->document)->properties)
        ->keyBy(fn ($s) => $s->name);

    expect($props->get('date_field'))->toBeInstanceOf(StringSchema::class)
        ->and($props->get('date_field')->description)
        ->toBe('Issue date- Convert in dd/mm/yyyy format');
});

it('defaults empty additional_info_for_prompt to an empty string', function () {
    $detail = Model::unguarded(fn () => new DocumentDetail(['name' => 'bare', 'type' => DetailType::String->getValue(), 'additional_info_for_prompt' => null]));
    $detailSet = new DetailSet;
    $detailSet->setRelation('documentDetails', collect([$detail]));
    $document = new Document;
    $document->setRelation('detailSet', $detailSet);

    $prop = collect($this->service->generate($document)->properties)->first();

    expect($prop->name)->toBe('bare')
        ->and($prop->description)->toBe('');
});
