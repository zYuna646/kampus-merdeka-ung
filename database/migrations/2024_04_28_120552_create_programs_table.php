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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Kolom nama program
            $table->text('kegiatan'); // Kolom kegiatan program
            $table->foreignId('program_kampus_id')->constrained('program_kampuses')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->foreignId('studi_id')->constrained('studis')->onDelete('cascade'); // Kolom untuk menampung id studi sebagai kunci asing
            $table->string('sop_pob'); // Kolom SOP/POB
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
