<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumngToPengajuanDagulirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_dagulir', function (Blueprint $table) {
            $table->string('status_pernikahan')->after('status');
            $table->string('foto_ktp')->after('status_pernikahan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_dagulir', function (Blueprint $table) {
            //
        });
    }
}
