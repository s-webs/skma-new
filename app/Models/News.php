<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends BaseModel
{

    protected $fillable = [
        'title->ru',
        'title->kz',
        'title->en',
        'text_ru',
        'text_kz',
        'text_en',
        'views_ru',
        'views_kz',
        'views_en',
        'preview_ru',
        'preview_kz',
        'preview_en',
        'published',
        'author',
        'department',
        'slug_ru',
        'slug_kz',
        'slug_en',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'images' => 'json',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
