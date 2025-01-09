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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->string('link_ru')->nullable();
            $table->string('link_kz')->nullable();
            $table->string('link_en')->nullable();

            $table->integer('order')->nullable();
            $table->integer('parent_id')->nullable();

            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
