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
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['activity', 'quiz', 'seatwork']); // Added type column
            $table->string('status')->default('visible');
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('section_id')->constrained()->onDelete('cascade')->nullable();// Optional: If you want to assign activities to sections
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_activities');
    }
};