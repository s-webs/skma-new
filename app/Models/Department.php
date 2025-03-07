<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $casts = [
        'staff_ru' => 'json',
        'staff_kz' => 'json',
        'staff_en' => 'json',
        'contacts_ru' => 'json',
        'contacts_kz' => 'json',
        'contacts_en' => 'json',
    ];
}
