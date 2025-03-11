<?php

namespace App\Models;

use GeoIp2\Database\Reader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Advert extends BaseModel
{
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }
}
