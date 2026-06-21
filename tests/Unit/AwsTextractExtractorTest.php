<?php

use App\Services\AwsTextractService;

// Unit tests for the pure block parsers in AwsTextractService. These methods
// take a Textract "Blocks" array and transform it with no external I/O — no
// DB, no mocks, no AWS client (we never call textExtractor()).
beforeEach(function () {
    $this->blocks = require __DIR__.'/../Fixtures/textract_blocks.php';
    $this->service = new AwsTextractService;
});

it('collects LINE block text in order via extractRawLines', function () {
    expect($this->service->extractRawLines($this->blocks))
        ->toBe(['Invoice Total', 'Name John']);
});

it('builds a row->header-keyed cell map via extractTablesCells', function () {
    $cellMap = $this->service->extractTablesCells($this->blocks);

    // Header row (RowIndex 1) is consumed as keys; only data rows appear.
    expect($cellMap)->toHaveCount(1)
        ->and($cellMap[2])->toBe(['Name' => 'John', 'Amount' => '100']);
});

it('assembles key->value form fields via extractFormFields', function () {
    expect($this->service->extractFormFields($this->blocks))
        ->toBe(['Name' => 'John']);
});

it('returns an empty array when there are no LINE blocks', function () {
    expect($this->service->extractRawLines([]))->toBe([]);
});

it('returns an empty cell map when there are no data rows', function () {
    // Only a header row (RowIndex 1) -> no RowIndex > 1 cells -> empty map
    $headerOnly = [
        ['Id' => 'h1', 'BlockType' => 'CELL', 'RowIndex' => 1, 'ColumnIndex' => 1,
            'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w1']]], ],
        ['Id' => 'w1', 'BlockType' => 'WORD', 'Text' => 'Header'],
    ];

    expect($this->service->extractTablesCells($headerOnly))->toBe([]);
});
