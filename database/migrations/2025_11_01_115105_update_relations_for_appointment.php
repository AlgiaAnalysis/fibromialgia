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
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_pat_id')->nullable();
            $table->unsignedBigInteger('doctor_doc_id')->nullable();

            $table->foreign('patient_pat_id')->references('pat_id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_doc_id')->references('doc_id')->on('doctors')->onDelete('cascade');
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
