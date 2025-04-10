<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkd extends Model
{
    protected $casts = [
        'files' => 'collection',
    ];

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
