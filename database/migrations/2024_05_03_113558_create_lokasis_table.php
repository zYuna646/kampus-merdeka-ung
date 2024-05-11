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
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->default(Str::random(10));

            $table->foreignId('program_id')->constrained('program_kampuses')->onDelete('cascade');
            $table->string('provinsi_id'); // Mengubah menjadi tipe data string
            $table->string('kabupaten_id'); // Mengubah menjadi tipe data string
            $table->string('kecamatan_id'); // Mengubah menjadi tipe data string
            $table->string('kelurahan_id'); // Mengubah menjadi tipe data string

            // Menambahkan constraint untuk setiap foreign key
            $table->foreign('provinsi_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('kabupaten_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('kelurahan_id')->references('id')->on('villages')->onDelete('cascade');

            $table->string('lokasi')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};
