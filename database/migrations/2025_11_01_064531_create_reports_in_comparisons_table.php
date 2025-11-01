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
        Schema::create('reports_in_comparisons', function (Blueprint $table) {
            $table->id('ric_id');
            $table->foreignId('patient_report_par_id')->constrained('patient_reports', 'par_id')->onDelete('cascade');
            $table->foreignId('report_comparison_rec_id')->constrained('report_comparisons', 'rec_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_in_comparisons');
    }
};