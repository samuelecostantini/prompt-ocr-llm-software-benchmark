<?php

namespace Tests\Fakes;

use App\Interfaces\OCRService;

/**
 * Stand-in for AwsTextractService in feature tests.
 *
 * AwsTextractService instantiates `new TextractClient(...)` internally and
 * reads the file from disk, so it cannot be exercised without real AWS
 * credentials and a real file. BulkRunJob / RunExtractionAction resolve it via
 * `app(AwsTextractService::class)`, so tests bind this fake to that FQCN and
 * inspect the recorded calls instead.
 */
class FakeOcrService implements OCRService
{
    /** @var array<int, string> file paths passed to textExtractor(), in call order */
    public array $calls = [];

    /** Override the JSON string returned by textExtractor(); null = default empty payload. */
    public ?string $returns = null;

    /**
     * Widened to ?string: tests seed Documents without real Spatie media, so
     * getFirstMediaPath('document') returns null and the orchestration passes
     * it through. The fake ignores the path; it never reads the file.
     */
    public function textExtractor(?string $filePath): string
    {
        $this->calls[] = $filePath;

        return $this->returns ?? json_encode([
            'cellMap' => [],
            'rawLines' => [],
            'formFields' => [],
        ]);
    }
}
