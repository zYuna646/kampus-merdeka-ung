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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique(); // Kolom NIDN dengan constraint unik
            $table->string('name'); // Kolom nama dosen
            $table->foreignId('studi_id')->constrained('studis')->onDelete('cascade'); // Kolom untuk menampung id studi sebagai kunci asing
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kolom untuk menampung id user sebagai kunci asing
            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
