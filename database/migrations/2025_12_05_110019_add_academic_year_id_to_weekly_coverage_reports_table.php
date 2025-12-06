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
        Schema::table('weekly_coverage_reports', function (Blueprint $table) {
            $table->foreignId('academic_year_id')
                ->nullable()
                ->after('recorded_by_user_id')
                ->constrained('academic_years')
                ->onDelete('cascade');

            $table->index('academic_year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_coverage_reports', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['academic_year_id']);
            $table->dropColumn('academic_year_id');
        });
    }
};
