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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('usr_id');
            $table->string('usr_name');
            $table->string('usr_email')->unique();
            $table->string('usr_password');
            $table->string('usr_role');
            $table->integer('usr_represented_agent');
            $table->date('usr_created_at');
            $table->date('usr_updated_at');
            $table->string('usr_cpf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
