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
            $table->string('dokumentasi')->nullable();
            $table->date('date');
            $table->text('msg')->nullable();
            $table->enum('status', ['terima', 'proses', 'tolak', 'belum'])->default('belum');
            $table->foreignId('program_transaction_id')->constrained('program_transactions')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->foreignId('weekly_log_id')->constrained('weekly_logs')->onDelete('cascade'); // Kolom untuk menampung id program kampus sebagai kunci asing
            $table->timestamps();

        });


        Schema::create('daily_log_activity', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('daily_log_id')->constrained('daily_logs')->onDelete('cascade');
            $table->foreignId('activity_log_id')->constrained('activity_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_log_activity');
        Schema::dropIfExists('daily_log');
    }
};
