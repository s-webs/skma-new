<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{

    protected $fillable = [
        'preview',
        'name_ru',
        'name_kz',
        'name_en',
        'description_ru',
        'description_kz',
        'description_en',
        'staff',
        'umkd',
        'documents',
        'portfolio',
        'documents_ru',
        'documents_kz',
        'documents_en',
        'contacts_ru',
        'contacts_kz',
        'contacts_en',
        'parent_id',
        'slug_ru',
        'slug_kz',
        'slug_en',
        'sort_order'
    ];

    protected $casts = [
        'staff' => 'json',
        'contacts_ru' => 'json',
        'contacts_kz' => 'json',
        'contacts_en' => 'json',
        'documents_ru' => 'json',
        'documents_kz' => 'json',
        'documents_en' => 'json',
        'umkd' => 'string',
        'portfolio' => 'string',
    ];

    protected $with = ['parent'];

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

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'parent_id', 'id');
    }

    public function umkd(): Department|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Umkd::class);
    }
}
