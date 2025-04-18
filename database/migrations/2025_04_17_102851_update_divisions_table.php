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
            Schema::table('divisions', function (Blueprint $table) {
                $table->dropColumn(['staff_ru', 'staff_kz', 'staff_en']);
                $table->json('staff')->nullable()->after('documents_en');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('staff');
            $table->json('staff_ru')->nullable()->after('contacts_en');
            $table->json('staff_kz')->nullable()->after('staff_ru');
            $table->json('staff_en')->nullable()->after('staff_kz');
        });
    }
};
