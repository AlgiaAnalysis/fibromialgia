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
            $table->id('user_id');
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->string('user_password');
            $table->string('user_domain');
            $table->string('user_role');
            $table->foreignId('user_represented_agent')->nullable()->constrained('users', 'user_id')->nullOnDelete();
            $table->date('user_created_at');
            $table->date('user_updated_at');
            $table->string('user_ref');
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