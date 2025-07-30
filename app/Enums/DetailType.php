<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DetailType: string implements HasLabel
{
    case String = 'string';
    case Number = 'number';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
