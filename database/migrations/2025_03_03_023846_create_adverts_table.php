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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('title_ru');
            $table->string('title_kz');
            $table->string('title_en');
            $table->longText('description_ru');
            $table->longText('description_kz');
            $table->longText('description_en');
            $table->string('slug_ru');
            $table->string('slug_kz');
            $table->string('slug_en');
            $table->integer('views_ru')->default(0);
            $table->integer('views_kz')->default(0);
            $table->integer('views_en')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};
