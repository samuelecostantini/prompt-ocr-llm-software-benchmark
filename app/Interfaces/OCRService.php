<?php

namespace App\Interfaces;

interface OCRService
{
    public function textExtractor(string $filePath);
}
