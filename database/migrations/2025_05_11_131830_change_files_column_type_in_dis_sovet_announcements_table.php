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
        Schema::table('dis_sovet_announcements', function (Blueprint $table) {
            Schema::table('dis_sovet_announcements', function (Blueprint $table) {
                $table->dropColumn('files');
            });

            Schema::table('dis_sovet_announcements', function (Blueprint $table) {
                $table->json('files')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dis_sovet_announcements', function (Blueprint $table) {
            Schema::table('dis_sovet_announcements', function (Blueprint $table) {
                $table->dropColumn('files');
            });

            Schema::table('dis_sovet_announcements', function (Blueprint $table) {
                $table->longText('files')->nullable();
            });
        });
    }
};
