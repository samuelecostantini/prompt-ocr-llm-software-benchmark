<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prompt extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(Run::class);
    }

    public function extractedFields()
    {
        return $this->hasManyThrough(ExtractedField::class, Run::class, 'prompt_id', 'run_id', 'id', 'id');
    }
}
