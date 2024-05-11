<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('mitra_transactions_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('mitra_transactions_id')->constrained('mitra_transactions')->onDelete('cascade');
            $table->foreignId('program_transactions_id')->constrained('program_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra_transactions_mahasiswa');
        Schema::dropIfExists('mitra_transactions');
    }
};
