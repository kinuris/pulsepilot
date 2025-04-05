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
        Schema::create('nutrition_records', function (Blueprint $table) {
            $table->id();

            $table->string('notes', 255);
            $table->string('day_description', 20);
            $table->text('foods_csv');
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
        Schema::dropIfExists('nutrition_records');
    }
};
