<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExtractedField extends Model
{
    use HasFactory;

    protected $table = 'extracted_fields';

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function documentDetail(): BelongsTo
    {
        return $this->belongsTo(DocumentDetail::class);
    }

    public function run(): BelongsTo
    {
        return $this->belongsTo(Run::class);
    }

    public function benchmarkResult(): HasOne
    {
        return $this->hasOne(BenchmarkResult::class);
    }
}
