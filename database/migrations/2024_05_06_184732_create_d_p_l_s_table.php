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
        Schema::create('d_p_l_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->timestamps();

        });

        Schema::create('d_p_l_program_transaction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('d_p_l_id')->constrained('d_p_l_s')->onDelete('cascade');
            $table->foreignId('program_transaction_id')->constrained('program_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_p_l_program_transaction');
        Schema::dropIfExists('d_p_l_s');
    }
};
