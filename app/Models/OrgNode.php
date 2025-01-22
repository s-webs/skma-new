<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgNode extends Model
{
    protected $fillable = [
        'parent_id', 'image', 'name_ru', 'name_kz', 'name_en',
        'description_ru', 'description_kz', 'description_en',
        'order', 'color'
    ];

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
