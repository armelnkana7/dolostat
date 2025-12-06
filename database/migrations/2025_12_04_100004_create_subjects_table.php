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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('establishment_id')->constrained('establishments')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('establishment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
