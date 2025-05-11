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
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->json('files_ru')->nullable()->after('views_en');
            $table->json('files_kz')->nullable()->after('views_en');
            $table->json('files_en')->nullable()->after('views_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropColumn('files_ru');
            $table->dropColumn('files_kz');
            $table->dropColumn('files_en');
        });
    }
};
