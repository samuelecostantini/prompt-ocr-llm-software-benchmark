<?php

namespace App;

use App\Enums\AwsSignals;
use Illuminate\Support\Facades\Log;

class AwsLowConfidenceError
{
    protected string $message;

    protected AwsSignals $errorValue;

    public function __construct(
        public float $confidence,
        public string $file_path,
    ) {
        $this->message = 'Confidence of image is to low: '.$this->confidence.'% < 85%. File path: '.$this->file_path;
        $this->errorValue = AwsSignals::Unreadable;
    }

    public function __invoke(): void
    {
        Log::error($this->message);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrorValue(): string
    {
        return $this->errorValue->getValue();
    }
}
