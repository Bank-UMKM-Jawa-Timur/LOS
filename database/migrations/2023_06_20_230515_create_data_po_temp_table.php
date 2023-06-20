<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPoTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_po_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_calon_nasabah_temp');
            $table->string('merk', 50);
            $table->string('tipe', 50);
            $table->string('tahun_kendaraan', 4)->nullable();
            $table->string('warna', 25)->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('jumlah');
            $table->integer('harga')->nullable();
            $table->timestamps();

            $table->foreign('id_calon_nasabah_temp')->references('id')->on('temporary_calon_nasabah')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_po_temp');
    }
}
