<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiCheckJob extends Model
{
    use HasFactory;

    protected $table = 'ai_check_jobs';

    protected $fillable = [
        'user_id',
        'status',
        'source_filename',
        'stored_path',
        'result_json',
        'pdf_lang',
        'pdf_ru_path',
        'pdf_kk_path',
        'pdf_en_path',
        'error_message',
    ];

    protected $casts = [
        'result_json' => 'array',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

