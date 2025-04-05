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
        Schema::create('glucose_records', function (Blueprint $table) {
            $table->id();

            // id INTEGER NOT NULL PRIMARY KEY,
            // glucose_level DECIMAL(5, 2) NOT NULL,
            // notes VARCHAR(255) NOT NULL,
            // is_a1c BOOLEAN NOT NULl,
            // blood_test_date DATETIME

            $table->decimal('glucose_level', 5, 2);
            $table->string('notes');
            $table->boolean('is_a1c');
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
        Schema::dropIfExists('glucose_records');
    }
};
