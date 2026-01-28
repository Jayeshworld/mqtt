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
        Schema::create('acs', function (Blueprint $table) {
            $table->id();
            $table->string('maac_id')->unique();
            $table->string('name');
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable()->comment('BTU or Tonnage');
            $table->enum('status', ['active', 'inactive', 'maintenance', 'out_of_order'])->default('active');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acs');
    }
};