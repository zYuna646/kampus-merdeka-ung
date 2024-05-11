<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('mitra_transaction_program_transaction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('mitra_transaction_id')
                  ->constrained('mitra_transactions')
                  ->onDelete('cascade')
                  ->name('mitra_transaction_program_transaction_mitra_transaction_id_foreign');

            $table->foreignId('program_transaction_id')
                  ->constrained('program_transactions')
                  ->onDelete('cascade')
                  ->name('mitra_transaction_program_transaction_program_transaction_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra_transaction_program_transaction');
        Schema::dropIfExists('mitra_transactions');
    }
};
