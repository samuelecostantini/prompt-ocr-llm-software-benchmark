<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BenchmarkResult extends Model
{
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }

    public function run(): BelongsTo
    {
        return $this->belongsTo(Run::class);
    }

    public function extractedField(): BelongsTo
    {
        return $this->belongsTo(ExtractedField::class);
    }
}
