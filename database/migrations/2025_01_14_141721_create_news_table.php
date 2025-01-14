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
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->string('title_ru');
            $table->string('title_kz');
            $table->string('title_en');

            $table->longText('text_ru');
            $table->longText('text_kz');
            $table->longText('text_en');

            $table->integer('views_ru')->default(0);
            $table->integer('views_kz')->default(0);
            $table->integer('views_en')->default(0);

            $table->text('slug_ru');
            $table->text('slug_kz');
            $table->text('slug_en');

            $table->text('preview_ru');
            $table->text('preview_kz')->nullable();
            $table->text('preview_en')->nullable();

            $table->string('author')->default('skma');
            $table->string('department')->default('academy');
            $table->boolean('published')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
