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
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('staff_ru');
            $table->dropColumn('staff_kz');
            $table->dropColumn('staff_en');

            $table->json('staff')->nullable()->after('description_en');
            $table->json('umkd')->nullable()->after('staff');
            $table->json('portfolio')->nullable()->after('umkd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->json('staff_ru')->nullable()->after('description_ru');
            $table->json('staff_kz')->nullable()->after('description_kz');
            $table->json('staff_en')->nullable()->after('description_en');

            $table->dropColumn('staff');
            $table->dropColumn('umkd');
            $table->dropColumn('portfolio');
        });
    }
};
