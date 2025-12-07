<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use App\Models\Run;
use All\Models\ExtractedField;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;



class BenchmarkResult extends Model
{
     public function document(): HasOne{
        return $this->hasOne(Document::class);
    }

    public function prompt(): HasOne
    {
        return $this->hasOne(Prompt::class);
    }
}
