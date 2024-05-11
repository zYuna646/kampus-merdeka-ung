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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique(); // Kolom NIM dengan constraint unik
            $table->string('name'); // Kolom nama mahasiswa
            $table->foreignId('studi_id')->constrained('studis')->onDelete('cascade'); // Kolom untuk menampung id studi sebagai kunci asing
            $table->string('angkatan'); // Kolom angkatan
            $table->uuid('user_id'); // Menggunakan UUID untuk kolom user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Kolom untuk menampung id user sebagai kunci asing
            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
