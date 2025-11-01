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
        Schema::create('patient_reports', function (Blueprint $table) {
            $table->id('par_id');
            $table->date('par_period_starts');
            $table->date('par_period_end');
            $table->string('par_status');
            $table->string('par_medication');
            $table->integer('par_score');
            $table->text('par_cli_resume');
            $table->string('par_type');
            $table->foreignId('patient_pat_id')->constrained('patients', 'pat_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_reports');
    }
};