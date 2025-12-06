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
        Schema::create('weekly_coverage_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained('establishments')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('recorded_by_user_id')->constrained('users')->onDelete('cascade');

            // Done metrics
            $table->unsignedInteger('nbr_hours_done')->default(0); // Heures réalisées
            $table->unsignedInteger('nbr_lesson_done')->default(0); // Leçons réalisées
            $table->unsignedInteger('nbr_lesson_dig_done')->default(0); // Leçons digitalisées réalisées
            $table->unsignedInteger('nbr_tp_done')->default(0); // TP réalisés
            $table->unsignedInteger('nbr_tp_dig_done')->default(0); // TP digitalisés réalisés

            $table->timestamps();

            $table->index('establishment_id');
            $table->index('program_id');
            $table->index('recorded_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_coverage_reports');
    }
};
