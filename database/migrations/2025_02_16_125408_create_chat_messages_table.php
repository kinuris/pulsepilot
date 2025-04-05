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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();

            $table->enum('sender_type', ['patient', 'doctor']);
            $table->enum('message_type', ['text', 'image', 'pdf']);

            $table->text('message')->nullable();
            $table->string('path')->nullable();

            $table->foreignId('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreignId('user_id')
                ->references('id')
                ->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
