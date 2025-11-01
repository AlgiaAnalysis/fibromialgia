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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('app_id');
            $table->date('app_date');
            $table->string('app_diagnosis');
            $table->foreignId('pat_id')->constrained('patients', 'pat_id')->onDelete('cascade');
            $table->foreignId('doc_id')->constrained('doctors', 'doc_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};