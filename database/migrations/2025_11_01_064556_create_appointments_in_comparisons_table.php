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
        Schema::create('appointments_in_comparisons', function (Blueprint $table) {
            $table->id('aic_id');
            $table->foreignId('appointment_app_id')->constrained('appointments', 'app_id')->onDelete('cascade');
            $table->foreignId('report_comparison_rec_id')->constrained('report_comparisons', 'rec_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_in_comparisons');
    }
};