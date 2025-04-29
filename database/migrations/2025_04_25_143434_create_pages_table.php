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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->longText('description_ru');
            $table->longText('description_kz');
            $table->longText('description_en');

            $table->string('slug_ru');
            $table->string('slug_kz');
            $table->string('slug_en');

            $table->integer('division_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
