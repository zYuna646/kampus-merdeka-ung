<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('name');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('guru_lokasi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_lokasi');
        Schema::dropIfExists('gurus');
    }
};
