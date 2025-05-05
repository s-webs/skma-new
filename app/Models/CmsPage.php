<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'name_ru',
        'name_kz',
        'name_en',
        'text_ru',
        'text_kz',
        'text_en',
        'slug_ru',
        'slug_kz',
        'slug_en',
        'views_ru',
        'views_kz',
        'views_en',
        'parent_id',
    ];

}
