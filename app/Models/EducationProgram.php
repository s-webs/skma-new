<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class EducationProgram extends BaseModel
{
    public function announcements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DisSovetAnnouncement::class, 'education_program_id', 'id');
    }
}
