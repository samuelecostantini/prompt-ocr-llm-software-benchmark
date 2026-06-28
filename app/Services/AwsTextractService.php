<?php

namespace App\Services;

use App\AwsLowConfidenceError;
use App\Interfaces\OCRService;
use Aws\Textract\TextractClient;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Timer\Exception;
use setasign\Fpdi\Fpdi;

class AwsTextractService implements OCRService
{
    public function textExtractor(string $filePath): string|AwsLowConfidenceError|null
    {
        Log::channel('extraction')->info('start aws textract service, setting up the TextractClient...');

        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => config('awstextract.region'),
            'credentials' => [
                'key' => config('awstextract.key'),
                'secret' => config('awstextract.secret'),
            ],
        ]);

        $cellMap = [];
        $rawLines = [];
        $formFields = [];

        Log::channel('extraction')->info('open file at path: '.$filePath);

        try {
            $fp_image = fopen($filePath, 'rb');
            $image = fread($fp_image, filesize($filePath));
            fclose($fp_image);
        } catch (Exception $e) {
            Log::channel('extraction')->error('fopen error: '.$e->getMessage());
        }

        try {
            $result = $textractClient->analyzeDocument(
                [
                    'Document' => [
                        'Bytes' => $image,
                    ],
                    'FeatureTypes' => ['TABLES', 'FORMS'],
                ]
            );
        } catch (Exception $e) {
            Log::channel('extraction')->error('analyzeDocument error: '.$e->getMessage());

            return null;
        }
        Log::channel('extraction')->info('analyzeDocument success');
        $blocks = $result['Blocks'];
        $sum = 0;
        $count = 0;
        foreach ($blocks as $block) {
            if (isset($block['Confidence'])) {
                $sum += $block['Confidence'];
                $count++;
            }
        }

        $avg = $sum / $count;

        Log::channel('extraction')->info('confidence level avg: '.$avg);
        // dump('confidence level avg: '.$avg);
        /*if ($avg < 80) {
            Log::channel('extraction')->error('low confidence');

            return new AwsLowConfidenceError($avg, $filePath);
        }*/

        $cellMap = array_merge($cellMap, $this->extractTablesCells($blocks));
        Log::channel('extraction')->info('$cellMap: '.json_encode($cellMap));
        $formFields = array_merge($formFields, $this->extractFormFields($blocks));
        Log::channel('extraction')->info('$formFields: '.json_encode($formFields));
        $rawLines = array_merge($rawLines, $this->extractRawLines($blocks));
        Log::channel('extraction')->info('$rawLines'.json_encode($rawLines));

        return json_encode([
            'cellMap' => $cellMap,
            'rawLines' => $rawLines,
            'formFields' => $formFields,
        ]);
    }

    public function extractTablesCells(array $blocks): array
    {
        $cellMap = [];
        $textMap = [];
        $headers = [];

        // Build a quick lookup for all blocks
        foreach ($blocks as $block) {
            $textMap[$block['Id']] = $block;
        }

        // First pass: extract headers
        foreach ($blocks as $block) {
            if ($block['BlockType'] === 'CELL' && $block['RowIndex'] === 1) {
                $col = $block['ColumnIndex'];
                $text = '';

                if (! empty($block['Relationships'])) {
                    foreach ($block['Relationships'] as $rel) {
                        if ($rel['Type'] === 'CHILD') {
                            foreach ($rel['Ids'] as $childId) {
                                if (isset($textMap[$childId]) && $textMap[$childId]['BlockType'] === 'WORD') {
                                    $text .= $textMap[$childId]['Text'].' ';
                                }
                            }
                        }
                    }
                }

                $headers[$col] = trim($text);
            }
        }

        // Second pass: extract data rows with header keys
        foreach ($blocks as $block) {
            if ($block['BlockType'] === 'CELL' && $block['RowIndex'] > 1) {
                $row = $block['RowIndex'];
                $col = $block['ColumnIndex'];
                $text = '';

                if (! empty($block['Relationships'])) {
                    foreach ($block['Relationships'] as $rel) {
                        if ($rel['Type'] === 'CHILD') {
                            foreach ($rel['Ids'] as $childId) {
                                if (isset($textMap[$childId]) && $textMap[$childId]['BlockType'] === 'WORD') {
                                    $text .= $textMap[$childId]['Text'].' ';
                                }
                            }
                        }
                    }
                }

                $headerKey = $headers[$col] ?? 'Column_'.$col;
                $cellMap[$row][$headerKey] = trim($text);
            }
        }

        return $cellMap;
    }

    public function extractFormFields(array $blocks): array
    {
        $keyMap = [];
        $valueMap = [];
        $blockMap = [];

        foreach ($blocks as $block) {
            $blockId = $block['Id'];
            $blockMap[$blockId] = $block;

            if ($block['BlockType'] === 'KEY_VALUE_SET') {
                if (isset($block['EntityTypes']) && in_array('KEY', $block['EntityTypes'])) {
                    $keyMap[$blockId] = $block;
                } else {
                    $valueMap[$blockId] = $block;
                }
            }
        }

        // === Extract Form Fields ===
        $formFields = [];

        foreach ($keyMap as $keyBlock) {
            $keyText = $this->getTextFromRelationships($keyBlock, $blockMap);

            $valueText = '';

            if (! empty($keyBlock['Relationships'])) {
                foreach ($keyBlock['Relationships'] as $rel) {
                    if ($rel['Type'] === 'VALUE') {
                        foreach ($rel['Ids'] as $valueId) {
                            $valueBlock = $valueMap[$valueId] ?? null;
                            if ($valueBlock) {
                                $valueText = $this->getTextFromRelationships($valueBlock, $blockMap);
                            }
                        }
                    }
                }
            }

            if ($keyText !== '') {
                $formFields[$keyText] = $valueText;
            }
        }

        return $formFields;
    }

    public function extractRawLines(array $blocks): array
    {
        $rawLines = [];
        foreach ($blocks as $value) {
            if (isset($value['BlockType']) && $value['BlockType'] == 'LINE') {
                if (isset($value['Text']) && $value['Text']) {
                    $text = $value['Text'];
                    $rawLines[] = $text;
                }
            }
        }

        return $rawLines;
    }

    public function textExtractorExpanse(string $file_path): mixed
    {

        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => config('awstextract.region'),
            'credentials' => [
                'key' => config('awstextract.key'),
                'secret' => config('awstextract.secret'),
            ],
        ]);

        $imagePath = $file_path;
        $fp_image = fopen($imagePath, 'rb');
        $image = fread($fp_image, filesize($imagePath));
        fclose($fp_image);

        $result2 = $textractClient->analyzeExpense([
            'Document' => [
                'Bytes' => $image,
            ],
        ]);
        // dd($result2);
        $result = collect([$result2['ExpenseDocuments'][0]['SummaryFields']]);

        $blocks = $result2['ExpenseDocuments'][0]['Blocks'];

        $text_for_prompt = '';

        foreach ($blocks as $value) {
            if (isset($value['BlockType']) && $value['BlockType']) {
                if (isset($value['Text']) && $value['Text']) {
                    $text = $value['Text'];
                    $text_for_prompt .= ' '.$text;
                }
            }
        }
        $result['invoice_text_for_count_product'] = $text_for_prompt;
        response($result, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="result.txt"');

        return $result;
    }

    private function getTextFromRelationships(mixed $keyBlock, array $blockMap)
    {
        $text = '';
        if (! empty($keyBlock['Relationships'])) {
            foreach ($keyBlock['Relationships'] as $rel) {
                if ($rel['Type'] === 'CHILD') {
                    foreach ($rel['Ids'] as $childId) {
                        if (isset($blockMap[$childId]) && isset($blockMap[$childId]['Text'])) {
                            $text .= $blockMap[$childId]['Text'].' ';
                        }
                    }
                }
            }
        }

        return trim($text);
    }

    public function splitPdf($filename, $end_directory = false)
    {

        $end_directory = $end_directory ? $end_directory : './';
        $new_path = preg_replace('/[\/]+/', '/', $end_directory.'/'.substr($filename, 0, strrpos($filename, '/')));

        if (! is_dir($new_path)) {
            // Will make directories under end directory that don't exist
            // Provided that end directory exists and has the right permissions
            mkdir($new_path, 0777, true);
        }

        $pdf = new FPDI;
        $pagecount = $pdf->setSourceFile($filename); // How many pages?

        $files = [];

        // Split each page into a new PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $new_pdf = new FPDI;
            $new_pdf->AddPage();
            $new_pdf->setSourceFile($filename);
            $new_pdf->useTemplate($new_pdf->importPage($i));

            try {
                $new_filename = $end_directory.str_replace('.pdf', '', $filename).'_'.$i.'.pdf';
                $new_pdf->Output($new_filename, 'F');
                $files[] = $new_filename;
            } catch (Exception $e) {
            }
        }

        return $files;
    }
}
