<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduate extends baseModel
{
    protected $fillable = [
        'name',
        'name_latin',
        'year',
        'photo',
        'description',
        'review',
        'language',
        'faculty',
    ];
}
