<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class NewsRepository
{
    public function paginate(string $langForColumns, int $perPage, ?int $userId): LengthAwarePaginator
    {
        $select = [
            'id',
            "title_{$langForColumns} as title",
            "preview_{$langForColumns} as preview",
            DB::raw("text_{$langForColumns} as text"),
            "slug_{$langForColumns} as slug",
            "views_{$langForColumns} as views",
            'author',
            'created_at',
        ];

        $q = News::select($select)
            ->withCount(['likes', 'comments'])
            ->latest('created_at');

        // boolean "liked" (есть ли лайк от текущего пользователя)
        if ($userId) {
            // Laravel 10+: alias для withExists
            $q->withExists([
                'likes as liked' => fn($qq) => $qq->where('user_id', $userId),
            ]);
        } else {
            $q->selectRaw('FALSE as liked');
        }

        return $q->paginate($perPage);
    }
}
