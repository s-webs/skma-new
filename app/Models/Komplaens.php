<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komplaens extends BaseModel
{
    protected $casts = [
        'cards_ru' => 'array',
        'cards_kz' => 'array',
        'cards_en' => 'array',
        'documents_ru' => 'array',
        'documents_kz' => 'array',
        'documents_en' => 'array',
        'images' => 'array',
    ];
}
