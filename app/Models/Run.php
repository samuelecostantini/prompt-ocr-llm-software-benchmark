<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Run extends Model
{
    use HasFactory;

    protected $table = 'runs';

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }

    public function extractedFields(): HasMany
    {
        return $this->hasMany(ExtractedField::class);
    }
}
