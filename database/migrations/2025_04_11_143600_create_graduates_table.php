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
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_latin');
            $table->integer('year');
            $table->string('photo')->nullable();

            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            $table->string('faculty_ru')->nullable();
            $table->string('faculty_kz')->nullable();
            $table->string('faculty_en')->nullable();

            $table->text('review')->nullable();
            $table->string('language')->nullable();
            $table->text('format')->nullable();
            $table->text('diplom_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduates');
    }
};
