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
        Schema::table('lowongans', function (Blueprint $table) {
            $table->boolean('isVerifLaporan')->default(true)->nullable();
            $table->boolean('isVerifDailyLogBooks')->default(true)->nullable();
            $table->boolean('isVerifWeeklyLogbooks')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn('isVerifLaporan');
            $table->dropColumn('isVerifDailyLogBooks');
            $table->dropColumn('isVerifWeeklyLogbooks');
        });
    }
};
