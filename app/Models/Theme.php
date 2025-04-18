<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public static function getActive()
    {
        return self::query()->where('active', true)->first();
    }
}
