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
        Schema::table('themes', function (Blueprint $table) {
            $table->string('dark')->nullable()->after('code');
            $table->string('halftone')->nullable()->after('code');
            $table->string('main')->nullable()->after('code');
            $table->string('secondary')->nullable()->after('code');
            $table->string('primary')->nullable()->after('code');
            $table->string('heading')->nullable()->after('code');
            $table->string('extra')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn('dark');
            $table->dropColumn('halftone');
            $table->dropColumn('main');
            $table->dropColumn('secondary');
            $table->dropColumn('primary');
            $table->dropColumn('heading');
            $table->dropColumn('extra');
        });
    }
};
