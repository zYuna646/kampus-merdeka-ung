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
        Schema::table('program_transactions', function (Blueprint $table) {
            $table->string('total_pembayran')->default('')->after('status_mahasiswa');
            $table->string('ukuran_baju')->default('')->after('total_pembayran');
            $table->string('bukti_pembayaran')->default('')->after('ukuran_baju');
            $table->boolean('status_pembayran')->default(false)->after('bukti_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'total_pembayran',
                'ukuran_baju',
                'bukti_pembayaran',
                'status_pembayran'
            ]);
        });
    }
};
