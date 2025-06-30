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
        Schema::table('for_students', function (Blueprint $table) {
            $table->dropColumn('elective_catalog');

            $table->string('electiveCatalog_ru')->after('schedule_exam')->nullable();
            $table->string('electiveCatalog_kz')->after('schedule_exam')->nullable();
            $table->string('electiveCatalog_en')->after('schedule_exam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('for_students', function (Blueprint $table) {
            //
        });
    }
};
