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
        Schema::create('medication_records', function (Blueprint $table) {
            $table->id();

            $table->string('medicine_name');
            $table->string('medicine_route');
            $table->string('medicine_form');
            $table->decimal('medicine_dosage', 5, 2);
            $table->dateTime('medication_reminder_date');
            $table->dateTime('recorded_time_taken')->nullable();

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
        Schema::dropIfExists('medication_records');
    }
};
