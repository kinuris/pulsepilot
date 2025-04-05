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
        Schema::create('bmi_records', function (Blueprint $table) {
            $table->id();

            // id INTEGER PRIMARY KEY NOT NULL,
            // height DECIMAL(3, 2) NOT NULL,
            // notes VARCHAR(255) NOT NULL,
            // weight DECIMAL(5, 2) NOT NULL,
            // created_at DATETIME NOT NULL

            $table->decimal('height', 3, 2);
            $table->string('notes', 255);
            $table->decimal('weight', 5, 2);
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
        Schema::dropIfExists('bmi_records');
    }
};
