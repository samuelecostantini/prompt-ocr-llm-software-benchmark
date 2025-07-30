<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DetailFormat: string implements HasLabel
{
    case Date = 'date';
    case NoFormat = '';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
