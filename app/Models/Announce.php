<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announce extends BaseModel
{
    protected $fillable = [
        'title_ru',
        'title_kz',
        'title_en',
        'description_ru',
        'description_kz',
        'description_en',
        'link_ru',
        'link_kz',
        'link_en',
        'image_ru',
        'image_kz',
        'image_en',
        'is_published',
        'created_at',
        'updated_at'
    ];

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }
}
