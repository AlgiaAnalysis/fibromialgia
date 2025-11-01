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
            $table->id('pat_id');
            $table->date('pat_disease_discover_date');
            $table->boolean('pat_sex');
            $table->boolean('pat_stopped_treatment');
            $table->integer('pat_streak');
            $table->boolean('pat_gave_informed_diagnosis');
            $table->boolean('pat_hundred_days');
            $table->boolean('pat_two_hundred_days');
            $table->boolean('pat_three_days');
            $table->string('pat_gender');
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