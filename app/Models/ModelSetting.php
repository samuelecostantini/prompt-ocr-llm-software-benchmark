<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelSetting extends Model
{
    protected $fillable = ['provider', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];
}