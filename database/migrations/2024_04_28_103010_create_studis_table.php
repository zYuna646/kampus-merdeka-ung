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
        Schema::create('studis', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('name'); // Kolom nama studi
            $table->string('slug')->unique(); // Kolom slug studi dengan constraint unik
            $table->string('code')->nullable(); // Kolom kode studi (opsional)
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studis');
    }
};
