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
        Schema::table('doctor_patients', function (Blueprint $table) {
            $table->foreignId('doctor_doc_id')->constrained('doctors', 'doc_id')->onDelete('cascade');
            $table->foreignId('patient_pat_id')->constrained('patients', 'pat_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
