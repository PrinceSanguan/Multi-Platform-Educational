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
        // Create the sections table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Section nam
            $table->timestamps();
        });

        // Create the pivot table for section-user relationships
        Schema::create('section_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_user');
        Schema::dropIfExists('sections');
    }
};
