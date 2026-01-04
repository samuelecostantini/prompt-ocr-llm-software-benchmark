<?php

namespace App\Services;

use App\Enums\DetailType;
use App\Models\Document;
use Prism\Prism\Schema\BooleanSchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

class DetailSchemaService
{
    public function generate(Document $document): ObjectSchema
    {

        $schema = [];

        $documentDetails = $document->detailSet->documentDetails;

        foreach ($documentDetails as $ocrDocumentDetail) {
            $schema[] = match ($ocrDocumentDetail->type) {
                DetailType::String->getValue() => new StringSchema(
                    name: $ocrDocumentDetail->name,
                    description: $ocrDocumentDetail->additional_info_for_prompt ?? ''
                ),
                DetailType::Number->getValue() => new NumberSchema(
                    name: $ocrDocumentDetail->name,
                    description: $ocrDocumentDetail->additional_info_for_prompt ?? ''
                ),
                DetailType::Date->getValue() => new StringSchema(
                    name: $ocrDocumentDetail->name,
                    description: ($ocrDocumentDetail->additional_info_for_prompt ?? '') . '- Convert in dd/mm/yyyy format'
                ),
                default => new StringSchema(
                    name: $ocrDocumentDetail->name,
                    description: $ocrDocumentDetail->additional_info_for_prompt ?? ''
                ),
            };
        }

        return new ObjectSchema(
            name: 'document',
            description: 'Document Schema',
            properties: $schema,
        );
    }
}
