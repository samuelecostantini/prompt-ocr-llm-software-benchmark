<?php

namespace Tests\Support;

use App\Services\AwsTextractService;
use App\Services\OpenAIService;
use Tests\Fakes\FakeAiService;
use Tests\Fakes\FakeOcrService;

/**
 * Bind the OCR + AI fakes into the container for the current test.
 *
 * Bound as singletons so every `app(AwsTextractService::class)` /
 * `app(OpenAIService::class)` resolve inside the orchestration returns the same
 * instance, letting the test assert call counts and toggle fake behaviour
 * (e.g. FakeAiService::$withUnknownKey) after binding.
 */
trait BindsFakes
{
    protected function setUpBindsFakes(): void
    {
        $this->app->singleton(AwsTextractService::class, FakeOcrService::class);
        $this->app->singleton(OpenAIService::class, FakeAiService::class);
    }

    protected function fakeOcr(): FakeOcrService
    {
        return $this->app->make(AwsTextractService::class);
    }

    protected function fakeAi(): FakeAiService
    {
        return $this->app->make(OpenAIService::class);
    }
}
