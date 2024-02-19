<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameToDdPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dd_pembayaran', function (Blueprint $table) {
            $table->renameColumn('id_dd_loan', 'no_loan');
            $table->renameColumn('tanggal_angsuran', 'tanggal_pembayaran');
            $table->renameColumn('pokok_angsuran', 'pokok_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dd_pembayaran', function (Blueprint $table) {
            //
        });
    }
}
