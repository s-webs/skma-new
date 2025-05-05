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
        Schema::create('dis_sovet_information', function (Blueprint $table) {
            $table->id();
            $table->string('title_ru');
            $table->string('title_kz');
            $table->string('title_en');
            $table->longText('description_ru')->nullable();
            $table->longText('description_kz')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('file_ru');
            $table->string('file_kz');
            $table->string('file_en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dis_sovet_information');
    }
};
