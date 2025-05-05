<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class DisSovetAnnouncement extends BaseModel
{
    protected $casts = [
        'files' => 'collection'
    ];

    public function educationProgram(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EducationProgram::class);
    }

    public function getFilesAttribute()
    {
        $rawFiles = json_decode($this->attributes['files'] ?? '[]');

        return collect($rawFiles)->map(function ($path) {
            return [
                'path' => $path,
                'name' => pathinfo($path, PATHINFO_FILENAME),
            ];
        });
    }



}
