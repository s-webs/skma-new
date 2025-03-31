<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForStudent extends baseModel
{
    protected $casts = [
        'cards_ru' => 'array',
        'cards_kz' => 'array',
        'cards_en' => 'array',
        'schedule_lesson' => 'array',
        'schedule_exam' => 'array',
    ];
}
