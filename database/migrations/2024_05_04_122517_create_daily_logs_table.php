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
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->text('desc');
            $table->date('date');
            $table->text('msg')->nullable();
            $table->enum('status', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->foreignId('program_transaction_id')->constrained('program_transactions')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->foreignId('weekly_log_id')->constrained('weekly_logs')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
