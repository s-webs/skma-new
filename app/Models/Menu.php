<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{
    protected $fillable = [
        'name_ru',
        'name_kz',
        'name_en',
        'link_ru',
        'link_kz',
        'link_en',
        'sort_order',
        'parent_id',
        'icon',
    ];

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }
}
