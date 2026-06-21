<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailSet extends Model
{
    use HasFactory;

    public function documentDetails(): hasMany
    {
        return $this->hasMany(DocumentDetail::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
