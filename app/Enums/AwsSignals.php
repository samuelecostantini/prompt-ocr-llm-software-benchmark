<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AwsSignals: string implements HasLabel
{
    case Unreadable = 'unreadable';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
