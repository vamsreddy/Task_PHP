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
            $table->string('patient_no')->unique();
            $table->date('date');
            $table->string('patient_name');
            $table->integer('age');
            $table->string('gender');
            $table->string('contact_no')->unique();
            $table->string('room_bed_no')->unique();
            $table->string('doctor_name');
            $table->string('specialist');
            $table->text('treatment_details');
            $table->string('prepared_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
