<?php

/**
 * Minimal hand-built AWS Textract "Blocks" payload covering the block types
 * the pure extractors in AwsTextractService care about: WORD, LINE, CELL
 * (with header row + data row), and KEY_VALUE_SET (key + value).
 *
 * Returned as an array of blocks (the shape of $result['Blocks'] from
 * AnalyzeDocument).
 */
return [
    // WORD blocks carry the actual text; CELL/KEY_VALUE_SET reference them.
    ['Id' => 'w1', 'BlockType' => 'WORD', 'Text' => 'Name'],
    ['Id' => 'w2', 'BlockType' => 'WORD', 'Text' => 'Amount'],
    ['Id' => 'w3', 'BlockType' => 'WORD', 'Text' => 'John'],
    ['Id' => 'w4', 'BlockType' => 'WORD', 'Text' => '100'],
    ['Id' => 'w5', 'BlockType' => 'WORD', 'Text' => 'Invoice'],
    ['Id' => 'w6', 'BlockType' => 'WORD', 'Text' => 'Total'],

    // LINE blocks -> extractRawLines
    ['Id' => 'l1', 'BlockType' => 'LINE', 'Text' => 'Invoice Total'],
    ['Id' => 'l2', 'BlockType' => 'LINE', 'Text' => 'Name John'],

    // CELL blocks -> extractTablesCells (row 1 = headers, row 2 = data)
    [
        'Id' => 'c1', 'BlockType' => 'CELL', 'RowIndex' => 1, 'ColumnIndex' => 1,
        'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w1']]],
    ],
    [
        'Id' => 'c2', 'BlockType' => 'CELL', 'RowIndex' => 1, 'ColumnIndex' => 2,
        'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w2']]],
    ],
    [
        'Id' => 'c3', 'BlockType' => 'CELL', 'RowIndex' => 2, 'ColumnIndex' => 1,
        'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w3']]],
    ],
    [
        'Id' => 'c4', 'BlockType' => 'CELL', 'RowIndex' => 2, 'ColumnIndex' => 2,
        'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w4']]],
    ],

    // KEY_VALUE_SET blocks -> extractFormFields (kv1 key "Name" -> kv2 value "John")
    [
        'Id' => 'kv1', 'BlockType' => 'KEY_VALUE_SET', 'EntityTypes' => ['KEY'],
        'Relationships' => [
            ['Type' => 'CHILD', 'Ids' => ['w1']],
            ['Type' => 'VALUE', 'Ids' => ['kv2']],
        ],
    ],
    [
        'Id' => 'kv2', 'BlockType' => 'KEY_VALUE_SET',
        'Relationships' => [['Type' => 'CHILD', 'Ids' => ['w3']]],
    ],
];
