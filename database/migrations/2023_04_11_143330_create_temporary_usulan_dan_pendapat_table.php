<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryUsulanDanPendapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_usulan_dan_pendapat', function (Blueprint $table) {
            $table->id();
            $table->integer('id_temp')->nullable();
            $table->integer('id_aspek')->nullable();
            $table->string('usulan')->nullable();
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
        Schema::dropIfExists('temporary_usulan_dan_pendapat');
    }
}
