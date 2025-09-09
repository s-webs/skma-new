<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'news_id',
        'created_at',
        'updated_at'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function news(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
