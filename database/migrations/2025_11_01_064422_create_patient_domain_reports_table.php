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
        Schema::create('patient_domain_reports', function (Blueprint $table) {
            $table->id('pdr_id');
            $table->string('pdr_domain');
            $table->integer('pdr_score');
            $table->foreignId('pat_id')->constrained('patients', 'pat_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_domain_reports');
    }
};