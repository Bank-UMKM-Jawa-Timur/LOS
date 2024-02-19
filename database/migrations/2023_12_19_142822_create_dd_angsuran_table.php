<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dd_angsuran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dd_loan');
            $table->timestamp('tanggal_angsuran');
            $table->double('baki_debet',12,0,true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dd_angsuran');
    }
}
