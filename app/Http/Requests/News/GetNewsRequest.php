<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class GetNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lang' => 'nullable|in:ru,kk,en',
            'per_page' => 'nullable|integer|min:1|max:50',
            'page' => 'nullable|integer|min:1',
        ];
    }

    public function langForColumns(): string
    {
        // в БД у тебя язык 'kz', а с клиента приходит 'kk'
        $lang = $this->get('lang', 'ru');
        return $lang === 'kk' ? 'kz' : $lang; // для колонок
    }

    public function langForCarbon(): string
    {
        // для переводов Carbon используем именно kk/ru/en
        return $this->get('lang', 'ru');
    }

    public function perPage(): int
    {
        return (int)$this->get('per_page', 10);
    }
}
