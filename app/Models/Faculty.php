<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends BaseModel
{
    protected $casts = [
        'staff_ru' => 'array',
        'staff_kz' => 'array',
        'staff_en' => 'array',
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

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany|Faculty
    {
        $lang = app()->getLocale();
        return $this->hasMany(Department::class, 'parent_id', 'id')
            ->orderBy("name_{$lang}", 'asc');
    }
}
