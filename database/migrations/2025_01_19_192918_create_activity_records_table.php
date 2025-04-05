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
        Schema::create('activity_records', function (Blueprint $table) {
            $table->id();

            // type VARCHAR(15) NOT NULL,
            // duration INTEGER NOT NULL,
            // frequency INTEGER NOT NULL,
            // created_at DATETIME NOT NULL,
            // notes VARCHAR(255) NOT NULL

            $table->string('type', 15);
            $table->integer('duration');
            $table->integer('frequency');
            $table->text('notes');
            $table->timestamp('recorded_at');

            $table->foreignId('patient_id')
                ->references('id')
                ->on('patients');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_records');
    }
};
