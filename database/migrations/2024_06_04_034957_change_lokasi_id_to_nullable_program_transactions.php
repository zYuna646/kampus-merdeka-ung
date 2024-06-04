<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            // Drop the existing foreign key constraint
            $table->dropForeign(['lokasi_id']);
        });

        // Make the column nullable and add the foreign key constraint again
        DB::statement('ALTER TABLE program_transactions MODIFY COLUMN lokasi_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE program_transactions ADD CONSTRAINT program_transactions_lokasi_id_foreign FOREIGN KEY (lokasi_id) REFERENCES lokasis(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_transactions', function (Blueprint $table) {
            // Drop the modified foreign key constraint
            $table->dropForeign(['lokasi_id']);
        });

        // Make the column not nullable and add the foreign key constraint again
        DB::statement('ALTER TABLE program_transactions MODIFY COLUMN lokasi_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE program_transactions ADD CONSTRAINT program_transactions_lokasi_id_foreign FOREIGN KEY (lokasi_id) REFERENCES lokasis(id) ON DELETE CASCADE');
    }
};
