<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTempatBerdiriToPengajuanDagulirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_dagulir', function (Blueprint $table) {
           $table->string('tempat_berdiri')->nullable()->change();
           $table->date('tanggal_berdiri')->nullable()->change();
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
