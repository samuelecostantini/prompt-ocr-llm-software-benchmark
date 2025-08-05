<?php

namespace App\Facades;

use App\Services\DetailSchemaService;
use Illuminate\Support\Facades\Facade;

/**
 * @see DetailSchemaService
 */
class DetailSchema extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DetailSchemaService::class;
    }
}
