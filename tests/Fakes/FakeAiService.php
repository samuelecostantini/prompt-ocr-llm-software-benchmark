<?php

namespace Tests\Fakes;

use App\Models\Document;
use App\Models\Prompt;

/**
 * Stand-in for OpenAIService in feature tests.
 *
 * OpenAIService calls Prism::structured() (a live OpenAI HTTP request). Since
 * BulkRunJob / RunExtractionAction resolve it via `app(OpenAIService::class)`,
 * tests bind this fake to that FQCN. readInvoice returns an array keyed by the
 * document's detail names so the orchestration can create matching
 * ExtractedField rows, and records every call for assertion.
 */
class FakeAiService
{
    /** @var array<int, array{document_id: int, prompt_id: int}> */
    public array $calls = [];

    /** Per-detail-name value overrides; default is "extracted-<name>". */
    public array $overrides = [];

    /** When true, also returns a key with no matching DocumentDetail (used to
     *  characterize RunExtractionAction's missing null-guard). */
    public bool $withUnknownKey = false;

    public function readInvoice(mixed $invoiceText, Document $document, Prompt $prompt): array
    {
        $this->calls[] = ['document_id' => $document->id, 'prompt_id' => $prompt->id];

        $result = [];
        foreach ($document->detailSet?->documentDetails ?? [] as $detail) {
            $result[$detail->name] = $this->overrides[$detail->name] ?? "extracted-{$detail->name}";
        }

        if ($this->withUnknownKey) {
            $result['nonexistent_detail'] = 'ghost';
        }

        return $result;
    }
}
