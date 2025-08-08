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
        Schema::create('elevators', function (Blueprint $table) {
            $table->id();
            $table->string('maac_id')->unique(); // Unique identifier for the elevator
            $table->string('name');
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('status')->default('operational'); // Added status column
            $table->string('remarks')->nullable(); // Optional remarks column
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //
            $table->string('created_by')->nullable(); // Optional column for tracking who created the elevator entry
            $table->string('updated_by')->nullable(); // Optional column for tracking who last updated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elevators');
    }
};
