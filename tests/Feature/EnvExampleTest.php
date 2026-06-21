<?php

// Regression guard for Phase 1 Fix #4: .env.example must ship with SQLite as
// the default DB connection and must include the OPENAI_API_KEY placeholder.
// A pure file-content assertion — cheap to run, catches a revert instantly.
it('uses SQLite as the default DB connection', function () {
    $env = file_get_contents(base_path('.env.example'));

    expect($env)->toContain('DB_CONNECTION=sqlite')
        ->and($env)->not->toContain('DB_CONNECTION=mysql');
});

it('includes the OPENAI_API_KEY placeholder', function () {
    expect(file_get_contents(base_path('.env.example')))
        ->toContain('OPENAI_API_KEY=');
});
