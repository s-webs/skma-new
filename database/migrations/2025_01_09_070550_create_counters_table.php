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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');
            $table->integer('count')->default(0);
            $table->text('image')->nullable();
            $table->string('link_ru')->nullable();
            $table->string('link_kz')->nullable();
            $table->string('link_en')->nullable();
            $table->boolean('link_external')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
