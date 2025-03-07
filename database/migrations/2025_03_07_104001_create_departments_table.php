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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();

            $table->string('preview');

            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->longText('description_ru');
            $table->longText('description_kz');
            $table->longText('description_en');

            $table->json('staff_ru')->nullable();
            $table->json('staff_kz')->nullable();
            $table->json('staff_en')->nullable();

            $table->json('contacts_ru')->nullable();
            $table->json('contacts_kz')->nullable();
            $table->json('contacts_en')->nullable();

            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
