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
        Schema::create('firebase_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('all'); // 'all', 'user', 'partner'
            $table->timestamp('scheduled_at')->nullable(); // For scheduled notifications
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->string('created_by')->nullable(); // User who created the notification
            $table->string('topic')->nullable(); // For topic-based notifications
            $table->string('route')->nullable(); // Route to redirect when notification is clicked
            $table->string('arguments')->nullable(); // Additional arguments for the route
            $table->text('body');
            $table->string('image')->nullable();
            $table->json('user_ids');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firebase_notifications');
    }
};
