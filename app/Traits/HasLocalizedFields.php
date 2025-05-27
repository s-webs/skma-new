<?php

namespace App\Traits;

trait HasLocalizedFields
{
    public function getAttribute($key)
    {
        // Для полей с суффиксом _язык
        if (preg_match('/^(.+?)_(' . implode('|', config('app.locales')) . ')$/', $key, $matches)) {
            return parent::getAttribute($key);
        }

        // Автоматическое определение локализованного поля
        foreach (config('app.locales') as $locale) {
            $localizedKey = "{$key}_{$locale}";
            if (array_key_exists($localizedKey, $this->attributes)) {
                return parent::getAttribute("{$key}_{$app->getLocale()}");
            }
        }

        return parent::getAttribute($key);
    }
}
