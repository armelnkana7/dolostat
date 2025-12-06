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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('establishment_id')->nullable()->constrained('establishments')->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->json('meta')->nullable();

            $table->index('establishment_id');
            $table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('establishment_id');
            $table->dropConstrainedForeignId('department_id');
            $table->dropColumn('meta');
        });
    }
};
