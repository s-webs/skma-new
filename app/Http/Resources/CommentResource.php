<?php

namespace App\Http\Resources;

class CommentResource
{
    public function toArray($request): array
    {
        // локаль для форматирования даты
        $rawLang = (string)$request->query('lang', 'ru');
        $locale = in_array($rawLang, ['ru', 'kk', 'en'], true) ? $rawLang : 'ru';

        return [
            'id' => (int)$this->id,
            'news_id' => (int)$this->news_id,
            'comment' => (string)$this->comment, // <-- поле из БД
            'created_at' => optional($this->created_at)->toISOString(),
            'created_at_formatted' => optional($this->created_at)
                ? $this->created_at->locale($locale)->translatedFormat('d MMM, HH:mm')
                : null,
            'user' => [
                'id' => (int)($this->user->id ?? 0),
                'name' => (string)($this->user->name ?? 'User'),
            ],
            'is_owner' => $request->user()?->id === $this->user_id,
        ];
    }
}
