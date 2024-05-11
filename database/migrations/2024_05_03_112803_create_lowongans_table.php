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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->default(Str::random(10));

            $table->foreignId('program_id')->constrained('program_kampuses')->onDelete('cascade');
            $table->string('tahun_akademik');
            $table->string('semester');
            $table->boolean('isLogBook')->default(true);
            $table->dateTime('pendaftaran_mulai');
            $table->dateTime('pendaftaran_selesai');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
