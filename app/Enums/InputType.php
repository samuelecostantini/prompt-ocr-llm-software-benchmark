<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InputType: string implements HasLabel
{
    case Text = 'text';
    case Number = 'number';
    case Select = 'select';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
