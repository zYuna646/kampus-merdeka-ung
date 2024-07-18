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
            $table->string('sk')->after('tanggal_selesai')->default(''); // Adding sk column after tanggal_selesai
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
            $table->dropColumn('sk'); // Dropping sk column during rollbacks
        });
    }
};
