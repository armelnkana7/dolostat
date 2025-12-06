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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained('establishments')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');

            // Planned metrics
            $table->unsignedInteger('nbr_hours')->default(0); // Heures prévues
            $table->unsignedInteger('nbr_lesson')->default(0); // Leçons prévues
            $table->unsignedInteger('nbr_lesson_dig')->default(0); // Leçons digitalisées prévues
            $table->unsignedInteger('nbr_tp')->default(0); // TP prévus
            $table->unsignedInteger('nbr_tp_dig')->default(0); // TP digitalisés prévus

            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('establishment_id');
            $table->index('classe_id');
            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
