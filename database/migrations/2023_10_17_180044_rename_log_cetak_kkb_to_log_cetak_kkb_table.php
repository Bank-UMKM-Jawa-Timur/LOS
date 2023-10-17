<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenameLogCetakKkbToLogCetakKkbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_cetak_kkb', function (Blueprint $table) {
            $table->string('no_pk', 25)->nullable();
            DB::statement("ALTER TABLE log_cetak_kkb RENAME log_cetak");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_cetak_kkb', function (Blueprint $table) {
            //
        });
    }
}
