<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToDdAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dd_angsuran', function (Blueprint $table) {
            $table->integer('kolek')->after('pokok_angsuran')->nullable();
            $table->text('keterangan')->nullable()->after('kolek');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dd_angsuran', function (Blueprint $table) {
            //
        });
    }
}
