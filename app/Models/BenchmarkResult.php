<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BenchmarkResult extends Model
{
    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }

    public function prompt(): HasOne
    {
        return $this->hasOne(Prompt::class);
    }

    public function extractedField(): HasOne
    {
        return $this->hasOne(ExtractedField::class, 'id', 'extracted_field_id');
    }
}
