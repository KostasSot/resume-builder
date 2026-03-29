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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            // Links this experience to a specific resume
            $table->foreignId('resume_id')->constrained()->cascadeOnDelete();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('duration')->nullable(); // e.g., "Jan 2020 - Present"
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
