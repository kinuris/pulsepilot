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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // id INTEGER NOT NULL PRIMARY KEY,
            // web_id INTEGER,
            // first_name VARCHAR(255) NOT NULL,
            // last_name VARCHAR(255) NOT NULL,
            // middle_name VARCHAR(255),
            // is_male BOOLEAN NOT NULL,
            // birthdate DATETIME NOT NULL,
            // province VARCHAR(50) NOT NULL,
            // municipality VARCHAR(50) NOT NULL,
            // barangay VARCHAR(50) NOT NULL,
            // address_description VARCHAR(255) NOT NULL,
            // zip_code VARCHAR(10) NOT NULL,
            // contact_number VARCHAR(20) NOT NULL

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('recovery_id')->unique();
            $table->dateTime('birthdate');
            $table->string('province', 50);
            $table->string('municipality', 50);
            $table->string('barangay', 50);
            $table->string('zip_code', 10);
            $table->enum('sex', ['male', 'female']);
            $table->string('address_description');
            $table->string('contact_number', 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
