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
        Schema::create('immunization_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->references('id')
                ->on('patients');

            $table->string('vaccine_name', 255);
            $table->date('administration_date');

            $table->unsignedInteger('dose_number')
                ->nullable();

            $table->string('manufacturer', 255)
                ->nullable();

            $table->string('notes')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunization_histories');
    }
};
