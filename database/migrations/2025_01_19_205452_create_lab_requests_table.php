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
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->references('id')
                ->on('patients');

            $table->foreignId('user_id')
                ->references('id')
                ->on('users');

            $table->string('type');
            $table->string('priority_level');
            $table->boolean('fasting_required');
            $table->text('clinical_indication');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
