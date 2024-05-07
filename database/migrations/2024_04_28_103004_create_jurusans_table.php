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
        // Buat tabel 'jurusans' untuk menyimpan data jurusan
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('name'); // Kolom nama jurusan
            $table->string('slug')->unique(); // Kolom slug jurusan dengan constraint unik
            $table->string('code')->nullable(); // Kolom kode jurusan (opsional)
            $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');

            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel 'jurusans' jika migrasi dirollback
        Schema::dropIfExists('jurusans');
    }
};
