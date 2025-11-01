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
        Schema::create('appointment_answers', function (Blueprint $table) {
            $table->id('apa_id');
            $table->string('apa_answer');
            $table->foreignId('question_que_id')->constrained('questions', 'que_id')->onDelete('cascade');
            $table->foreignId('appointment_app_id')->constrained('appointments', 'app_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_answers');
    }
};