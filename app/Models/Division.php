<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Division extends BaseModel
{
    protected $fillable = [
        'preview',
        'name_ru',
        'name_kz',
        'name_en',
        'description_ru',
        'description_kz',
        'description_en',
        'staff_ru',
        'staff_kz',
        'staff_en',
        'documents_ru',
        'documents_kz',
        'documents_en',
        'contacts_ru',
        'contacts_kz',
        'contacts_en',
        'slug_ru',
        'slug_kz',
        'slug_en',
        'parent_id',
        'sort_order',
    ];

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

    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order');
        });

        static::addGlobalScope('childrenOrder', function (Builder $builder) {
            $builder->with(['children' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }]);
        });
    }

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
