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
        Schema::table('for_students', function (Blueprint $table) {
            $table->string('academic_calendars')->nullable()->after('schedule_exam');
            $table->string('elective_catalog')->nullable()->after('schedule_exam');
            $table->json('video_materials')->nullable()->after('schedule_exam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('for_students', function (Blueprint $table) {
            $table->dropColumn('academic_calendars');
            $table->dropColumn('elective_catalog');
            $table->dropColumn('video_materials');
        });
    }
};
