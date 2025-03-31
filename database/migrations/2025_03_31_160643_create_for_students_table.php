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
        Schema::create('for_students', function (Blueprint $table) {
            $table->id();

            $table->string('title_ru');
            $table->string('title_kz');
            $table->string('title_en');

            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            $table->json('cards_ru')->nullable();
            $table->json('cards_kz')->nullable();
            $table->json('cards_en')->nullable();

            $table->json('schedule_lesson')->nullable();
            $table->json('schedule_exam')->nullable();

            $table->string('slug_ru')->unique();
            $table->string('slug_kz')->unique();
            $table->string('slug_en')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('for_students');
    }
};
