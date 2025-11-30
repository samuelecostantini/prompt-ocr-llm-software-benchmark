<?php

namespace App\Services;

use App\Enums\DetailType;
use App\Facades\DetailSchema;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractionResult;
use App\Models\Prompt;
use App\Models\Run;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\BooleanSchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Messages\Support\Image;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class OpenAIService
{
    public function readInvoice(mixed $invoiceText, Run $run): array
    {
        /**
         * @var User $user
         * @var DocumentDetail $documentDetails
         * @var Prompt $prompt
         */

        Log::channel('extraction')->info('starting OpenAiService -> readInvoice...');
        $document = $run->document;
        $prompt = $run->prompt;

        $invoiceSchema = DetailSchema::generate($document);

        Log::channel('extraction')->info('invoice schema used: '.json_encode($invoiceSchema));

        $defaultPrompt = 'You are provided with text extracted from an invoice or transport documents using an OCR system. Your goal is, given the provided schema,
                to extract details from a document. All of these documents are in italian. ';

        Log::channel('extraction')->info('setting up OpenAi api call with prism');
        Log::channel('extraction')->info('prompt: '. $prompt?->title? : 'default prompt');

        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($invoiceSchema)
            ->withPrompt(
                $prompt->text
                .'Extracted text: """'
                .$invoiceText.'"""'
            )
            ->asStructured();
        Log::channel('extraction')->info('response: '.json_encode($response->structured, JSON_PRETTY_PRINT));

        return $response->structured;
    }
}
