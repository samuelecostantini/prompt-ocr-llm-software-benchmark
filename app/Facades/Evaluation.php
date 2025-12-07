<?php

namespace App\Facades;

use App\Services\EvaluationService;
use Illuminate\Support\Facades\Facade;

class Evaluation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EvaluationService::class;
    }
}
