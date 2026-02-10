<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_check_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status', 32)->default('pending')->index();
            $table->string('source_filename');
            $table->string('stored_path');
            $table->json('result_json')->nullable();
            $table->string('pdf_lang', 8)->nullable();
            $table->string('pdf_ru_path')->nullable();
            $table->string('pdf_kk_path')->nullable();
            $table->string('pdf_en_path')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_check_jobs');
    }
};

