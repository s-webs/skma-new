<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('preview')->nullable();

            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->longText('description_ru');
            $table->longText('description_kz');
            $table->longText('description_en');

            $table->json('staff_ru')->nullable();
            $table->json('staff_kz')->nullable();
            $table->json('staff_en')->nullable();

            $table->json('documents_ru')->nullable();
            $table->json('documents_kz')->nullable();
            $table->json('documents_en')->nullable();

            $table->json('contacts_ru')->nullable();
            $table->json('contacts_kz')->nullable();
            $table->json('contacts_en')->nullable();

            $table->string('slug_ru')->unique()->nullable();
            $table->string('slug_kz')->unique()->nullable();
            $table->string('slug_en')->unique()->nullable();

            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
