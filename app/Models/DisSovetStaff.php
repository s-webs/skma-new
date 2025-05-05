<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class DisSovetStaff extends BaseModel
{
    protected $casts = [
        'file_ru' => 'array',
        'file_kz' => 'array',
        'file_en' => 'array',
    ];
}
