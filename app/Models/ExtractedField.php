<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtractedField extends Model
{
    protected $table = 'extracted_fields';

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function document_detail(): BelongsTo
    {
        return $this->belongsTo(DocumentDetail::class);
    }

    public function run(): BelongsTo
    {
        return $this->belongsTo(Run::class);
    }
}
