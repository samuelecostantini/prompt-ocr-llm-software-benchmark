<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroundTruth extends Model
{
    use HasFactory;

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function documentDetail(): BelongsTo
    {
        return $this->belongsTo(DocumentDetail::class);
    }
}
