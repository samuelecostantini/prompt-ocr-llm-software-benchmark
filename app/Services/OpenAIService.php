<?php

namespace App\Services;

use App\Enums\DetailType;
use App\Facades\DetailSchema;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\User;
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
    public function readInvoice(mixed $invoiceText, User $user): array
    {
        /**
         * @var User $user
         * @var DocumentDetail $documentDetails
         */

        $invoiceSchema = DetailSchema::generate($user);

        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($invoiceSchema)
            ->withPrompt('
                You are provided with text extracted from an invoice or transport documents using an OCR system. Your goal is, given the provided schema,
                to extract details from a document. All of these documents are in italian.
                Extracted text:
                """'
                .$invoiceText.'
                """')
            ->asStructured();

        return $response->structured;
    }

    public function compareAiDataWithDeclaredData(array $aiData, array $declaredData): array
    {
        $schema = [];
        foreach ($declaredData as $key => $value) {
            $schema[] = new BooleanSchema(
                name: $key,
                description: 'Whether the value of the field is the same as the value of the field in the invoice.'
            );
        }

        $invoiceSchema = new ObjectSchema(
            name: 'invoice',
            description: 'Invoice Schema',
            properties: $schema,
        );

        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($invoiceSchema)
            ->withSystemPrompt(view('prompts.invoice-compare-data', [
                'aiData' => $aiData,
                'declaredData' => $declaredData,
            ]))
            ->asStructured();

        return $response->structured;
    }

    /*public function generateTests(ObjectSchema $test_schema, string $test_case, string $validations, string $additional_description): array
    {
        return Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($test_schema)
            ->withSystemPrompt('Return a valid JSON example that complies with this schema.
                                Each key in the returned object must match a field name from the model defined in the schema.
                                The values must be simple test strings or valid examples (e.g., “Test Name”, “test@example.com”, “123456”).
                                This output will be used to auto-fill a form during automated tests, so it should be:
                                    •	Fully JSON-valid ✅
                                    •	Match the types specified in the schema ✅
                                    •	Contain at least one test value per property ✅

                                Rules you have to follow:
                                    1. Generate tests for this test case: '.$test_case.'.
                                    2. Respect this validations: '.$validations.'.
                                    3. Additional description: '.$additional_description.'.

                                ⚠️ Return only the final JSON object. Do not include code comments, descriptions, or explanations.')
            ->asStructured()
            ->structured;
    }*/

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
