<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends baseModel
{
    protected $fillable = [
        'name_ru',
        'name_kz',
        'name_en',
        'description_ru',
        'description_kz',
        'description_en',
        'slug_ru',
        'slug_kz',
        'slug_en',
        'division_id',
    ];

    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
