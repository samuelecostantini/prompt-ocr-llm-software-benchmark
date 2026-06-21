<?php

use App\Services\AwsTextractService;

// Regression guard for Phase 1 Fix #2: the config-typo class of bug.
// textExtractorExpanse() previously read config('awstextcract.*') (typo) and so
// got null AWS credentials. No behavioural mock can cheaply catch this — the
// service builds `new TextractClient(...)` internally — so we assert at two
// levels: the config namespace resolves, and the service source contains no
// typo. The source-grep assertion is intentional and documented as such.
it('resolves the awstextract config namespace (region/key/secret)', function () {
    expect(config('awstextract.region'))->toBe('us-east-1')
        ->and(config('awstextract.key'))->toBe('test')
        ->and(config('awstextract.secret'))->toBe('test');
});

it('does not resolve the typo\'d awstextcract namespace', function () {
    // The misspelled namespace used to silently return null for every key.
    expect(config('awstextcract.region'))->toBeNull()
        ->and(config('awstextcract.key'))->toBeNull();
});

it('never references the typo\'d config namespace in AwsTextractService source', function () {
    // Intentional source-grep guard — see file header comment.
    expect(file_get_contents((new \ReflectionClass(AwsTextractService::class))->getFileName()))
        ->not->toContain('awstextcract');
});
