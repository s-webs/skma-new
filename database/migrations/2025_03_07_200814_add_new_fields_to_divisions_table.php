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
        Schema::table('divisions', function (Blueprint $table) {
            $table->string('slug_ru')->after('contacts_en')->unique()->nullable();
            $table->string('slug_kz')->after('contacts_en')->unique()->nullable();
            $table->string('slug_en')->after('contacts_en')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('slug_ru');
            $table->dropColumn('slug_kz');
            $table->dropColumn('slug_en');
        });
    }
};
