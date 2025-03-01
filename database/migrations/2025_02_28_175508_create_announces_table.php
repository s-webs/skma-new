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
        Schema::create('announces', function (Blueprint $table) {
            $table->id();
            $table->string('title_ru');
            $table->string('title_kz');
            $table->string('title_en');
            $table->longText('description_ru')->nullable();
            $table->longText('description_kz')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('link_ru')->nullable();
            $table->string('link_kz')->nullable();
            $table->string('link_en')->nullable();
            $table->string('image_ru');
            $table->string('image_kz');
            $table->string('image_en');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announces');
    }
};
