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
        // Buat tabel 'roles' untuk menyimpan data peran (roles)
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('name'); // Kolom nama peran
            $table->string('slug'); // Kolom slug peran
            $table->timestamps(); // Kolom waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel 'roles' jika migrasi dirollback
        Schema::dropIfExists('roles');
    }
};
