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
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();

            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->longText('text_ru');
            $table->longText('text_kz');
            $table->longText('text_en');

            $table->string('slug_ru');
            $table->string('slug_kz');
            $table->string('slug_en');

            $table->integer('views_ru')->default(0);
            $table->integer('views_kz')->default(0);
            $table->integer('views_en')->default(0);

            $table->integer('parent_id')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
