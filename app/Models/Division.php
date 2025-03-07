<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends BaseModel
{
    protected $casts = [
        'staff_ru' => 'json',
        'staff_kz' => 'json',
        'staff_en' => 'json',
        'contacts_ru' => 'json',
        'contacts_kz' => 'json',
        'contacts_en' => 'json',
        'documents_ru' => 'json',
        'documents_kz' => 'json',
        'documents_en' => 'json',
    ];

    public function transformDocuments($documents): array
    {
        if (!$documents) {
            return [];
        }

        $transformedDocuments = [];
        foreach ($documents as $document) {
            $path = $document['document'][0];
            $originalName = basename($path);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $transformedDocuments[] = [
                'original_name' => $originalName,
                'path' => $path,
                'extension' => $extension,
            ];
        }

        return $transformedDocuments;
    }


    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Division::class, 'parent_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class, 'parent_id');
    }
}
