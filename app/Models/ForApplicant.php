<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForApplicant extends BaseModel
{
    protected $casts = [
        'cards_ru' => 'array',
        'cards_kz' => 'array',
        'cards_en' => 'array',
    ];
}
