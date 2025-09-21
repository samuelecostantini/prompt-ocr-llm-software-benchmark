<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailSet extends Model
{
    public function documentDetails(): hasMany
    {
        return $this->hasMany(DocumentDetail::class);
    }
}
