<?php

namespace App\Interfaces;

interface AIService
{
    public function chat(string $prompt, array $jsonSchema);
}
