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
        Schema::table('faculties', function (Blueprint $table) {
            Schema::table('faculties', function (Blueprint $table) {
                $table->dropColumn(['staff_ru', 'staff_kz', 'staff_en']);
                $table->json('staff')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn('staff');
            $table->json('staff_ru')->nullable();
            $table->json('staff_kz')->nullable();
            $table->json('staff_en')->nullable();
        });
    }
};
