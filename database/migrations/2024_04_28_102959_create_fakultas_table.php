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
        // Buat tabel 'fakultas' untuk menyimpan data fakultas
        Schema::create('fakultas', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('name'); // Kolom nama fakultas
            $table->string('slug')->unique(); // Kolom slug fakultas dengan constraint unik
            $table->string('code')->unique(); // Kolom kode fakultas (opsional) yang unik
            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel 'fakultas' jika migrasi dirollback
        Schema::dropIfExists('fakultas');
    }
};
