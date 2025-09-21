<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExtractionResult extends Model
{
    public function document(): HasOne{
        return $this->hasOne(Document::class);
    }

    public function prompt(): hasOne
    {
        return $this->hasOne(Prompt::class);
    }


}
