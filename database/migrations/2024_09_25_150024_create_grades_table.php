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
            // Foreign key to the users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Subject field
            $table->string('subject');

            // Quarter grade fields
            $table->float('first_quarter')->nullable();
            $table->float('second_quarter')->nullable();
            $table->float('third_quarter')->nullable();
            $table->float('fourth_quarter')->nullable();

            // Overall score field (if needed)
            $table->float('score')->nullable();

            // Timestamps
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
