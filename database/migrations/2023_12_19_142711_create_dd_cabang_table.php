<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dd_cabang', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_cabang', false, true);
            $table->double('dana_modal', 12, 0, true);
            $table->double('dana_idle', 12, 0, true);
            $table->double('plafon_akumulasi', 12, 0, true);
            $table->double('baki_debet', 12, 0, true);
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
        Schema::dropIfExists('dd_cabang');
    }
}
