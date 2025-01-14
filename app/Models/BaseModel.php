<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getProperty(string $property): ?string
    {
        $localizedProperty = $property . '_' . app()->getLocale();

        return $this->attributes[$localizedProperty] ?? null;
    }
}
