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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('section_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('subject_id')->constrained()->onDelete('cascade'); // Use subject_id as a foreign key
            $table->float('first_quarter')->nullable();
            $table->float('second_quarter')->nullable();
            $table->float('third_quarter')->nullable();
            $table->float('fourth_quarter')->nullable();
            $table->float('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
