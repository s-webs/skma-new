<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class DisSovetAnnouncement extends BaseModel
{
    protected $casts = [
        'files' => 'array'
    ];

    public function educationProgram(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EducationProgram::class);
    }
}
