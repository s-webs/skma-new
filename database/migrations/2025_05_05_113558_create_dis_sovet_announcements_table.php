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
        Schema::create('dis_sovet_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_program_id')->constrained()->onDelete('cascade');
            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');
            $table->longText('description_ru')->nullable();
            $table->longText('description_kz')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dis_sovet_announcements');
    }
};
