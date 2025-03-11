<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends BaseModel
{
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }
}
