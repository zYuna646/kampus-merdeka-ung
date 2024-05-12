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
            $table->date('start_date');
            $table->date('end_date');
            $table->text('msg')->nullable();
            $table->enum('status', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->foreignId('program_transaction_id')->constrained('program_transactions')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->timestamps();
        });

        Schema::create('activity_log_weekly_log', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('weekly_log_id')->constrained('weekly_logs')->onDelete('cascade');
            $table->foreignId('activity_log_id')->constrained('activity_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log_weekly_log');
        Schema::dropIfExists('weekly_logs');
    }
};
