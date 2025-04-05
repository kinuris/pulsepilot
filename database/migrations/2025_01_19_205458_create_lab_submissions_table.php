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
        Schema::create('lab_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lab_request_id')
                ->references('id')
                ->on('lab_requests');

            $table->enum('type', ['image', 'file']);
            $table->string('file_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_submissions');
    }
};
