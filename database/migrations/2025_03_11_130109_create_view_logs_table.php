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
        Schema::create('view_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('country_code')->nullable();
            $table->string('cookie_id')->nullable();
            $table->morphs('viewable');
            $table->string('locale');

            $table->unique(['cookie_id', 'viewable_id', 'viewable_type', 'locale']);
            $table->index(['ip_address']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_logs');
    }
};
