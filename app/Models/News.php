<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends BaseModel
{
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }
}
