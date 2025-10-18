<?php

namespace App\Services;

use App\Enums\DetailType;
use App\Facades\DetailSchema;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractionResult;
use App\Models\Prompt;
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
    public function readInvoice(mixed $invoiceText, Document $document): array
    {
        /**
         * @var User $user
         * @var DocumentDetail $documentDetails
         * @var Prompt $prompt
         */

        Log::channel('extraction')->info('starting OpenAiService -> readInvoice...');

        $prompt = $document->prompt;

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
                ?? $defaultPrompt
                .'Extracted text: """'
                .$invoiceText.'"""'
            )
            ->asStructured();
        Log::channel('extraction')->info('response: '.json_encode($response->structured));

        return $response->structured;
    }

    public function readInvoiceFromImg(Document $document): array
    {
        /**
         * @var User $user
         * @var DocumentDetail $documentDetails
         */
        $user = $document->user;

        $invoiceSchema = DetailSchema::generate($user);

        $message = new UserMessage(
            'You are provided with image of an invoice or transport documents. Your goal is, given the provided schema,
                    to extract details from the invoice or trasport document. All of these documents are in italian. They all are about purchases in the thermosanitary field.
                    These documents are by italian wholesalers to their customer (which are mostly installers).
                    All dates MUST follow the format d/m/Y.
                    ',
            [Image::fromPath($document->getFirstMediaPath('document'))]
        );
        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($invoiceSchema)
            ->withMessages([$message])
            ->asStructured();

        return $response->structured;
    }

    public function readInvoiceFromImgInvoiceOnly(string $invoiceText, Campaign $campaign, Invoice $invoice): array
    {
        $schema = [];

        foreach ($campaign->ocrDocumentDetails as $ocrDocumentDetail) {
            $schema[] = match ($ocrDocumentDetail->type) {
                DetailType::String => new StringSchema(
                    name: $ocrDocumentDetail->name,
                    description: $ocrDocumentDetail->additional_info_for_ai ?? ''
                ),
                DetailType::Number => new NumberSchema(
                    name: $ocrDocumentDetail->name,
                    description: $ocrDocumentDetail->additional_info_for_ai ?? ''
                )
            };
        }

        $schema[] = new BooleanSchema(
            name: 'valid',
            description: 'Is the text a valid invoice or document transport. If there is text from multiple documents, it is to be considered invalid.'
        );

        $invoiceSchema = new ObjectSchema(
            name: 'invoice',
            description: 'Invoice Schema',
            properties: $schema,
        );

        $message = new UserMessage(
            'You are provided with image of an invoice or transport documents. Your goal is, given the provided schema,
                    to extract details from the invoice or trasport document. All of these documents are in italian. They all are about purchases in the thermosanitary field.
                    These documents are by italian wholesalers to their customer (which are mostly installers).
                    All dates MUST follow the format d/m/Y.
                    ',
            [Image::fromPath($invoice->getFirstMediaPath('document'))]
        );
        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($invoiceSchema)
            ->withMessages([$message])
            ->asStructured();

        return $response->structured;
    }
}
