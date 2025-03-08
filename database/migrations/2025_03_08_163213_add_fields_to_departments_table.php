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
        Schema::table('departments', function (Blueprint $table) {
            $table->json('documents_ru')->after('staff_en')->nullable();
            $table->json('documents_kz')->after('staff_en')->nullable();
            $table->json('documents_en')->after('staff_en')->nullable();
            $table->string('slug_ru')->after('contacts_en')->unique()->nullable();
            $table->string('slug_kz')->after('contacts_en')->unique()->nullable();
            $table->string('slug_en')->after('contacts_en')->unique()->nullable();
            $table->integer('parent_id')->after('contacts_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('slug_ru');
            $table->dropColumn('slug_kz');
            $table->dropColumn('slug_en');
            $table->dropColumn('documents_ru');
            $table->dropColumn('documents_kz');
            $table->dropColumn('documents_en');
        });
    }
};
