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
        Schema::create('weekly_logs', function (Blueprint $table) {
            $table->id();
            $table->text('desc')->nullable();
            $table->integer('nilai')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('msg')->nullable();
            $table->enum('status', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->foreignId('program_transaction_id')->constrained('program_transactions')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_logs');
    }
};
