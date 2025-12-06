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
        Schema::table('programs', function (Blueprint $table) {
            // Ajouter une contrainte unique sur establishment_id, classe_id, subject_id, academic_year_id
            // Cela évite les doublons pour une même classe, matière, établissement et année scolaire
            $table->unique(['establishment_id', 'classe_id', 'subject_id', 'academic_year_id'], 'unique_program_per_class_subject_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropUnique('unique_program_per_class_subject_year');
        });
    }
};
