<?php

namespace App\Services;

use App\Enums\DetailType;
use App\Models\Document;
use App\Models\User;
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
                )
            };
        }
        /*$schema[] = new BooleanSchema(
            name: 'valid',
            description: 'Is the text of a document. If there is text from multiple documents, it is to be considered invalid.'
        );*/

        return new ObjectSchema(
            name: 'document',
            description: 'Document Schema',
            properties: $schema,
        );
    }
}
