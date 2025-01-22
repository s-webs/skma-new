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
        Schema::create('org_nodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('image')->nullable();

            $table->string('name_ru');
            $table->string('name_kz');
            $table->string('name_en');

            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            $table->integer('sort_order')->default(1);
            $table->string('color')->default('#000000');

            $table->foreign('parent_id')
                ->references('id')
                ->on('org_nodes')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_nodes');
    }
};
