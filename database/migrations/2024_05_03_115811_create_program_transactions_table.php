<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('program_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('rancangan')->default('');
            $table->enum('status_rancangan_dpl', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->enum('status_rancangan_pamong', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->string('msg_dpl')->default('');
            $table->string('msg_pamong')->default('');

            $table->boolean('status_mahasiswa')->default(false);
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_transactions');
    }
};
