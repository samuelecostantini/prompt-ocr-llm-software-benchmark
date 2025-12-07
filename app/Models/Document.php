<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('document')
            ->singleFile();
    }

    public function extractedFields(): HasMany
    {
        return $this->hasMany(ExtractedField::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'document_tag');
    }

    public function detailSet(): BelongsTo
    {
        return $this->belongsTo(DetailSet::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(Run::class);
    }

    public function groundTruths(): HasMany
    {
        return $this->hasMany(GroundTruth::class, 'document_id');
    }
}
