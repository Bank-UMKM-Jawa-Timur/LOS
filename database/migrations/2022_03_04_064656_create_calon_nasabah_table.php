<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_nasabah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kabupaten')->nullable();
            $table->foreignId('id_kecamatan')->nullable();
            $table->foreignId('id_desa')->nullable();
            $table->string('nama');
            $table->string('no_ktp',16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('status');
            $table->string('sektor_kredit');
            $table->string('jenis_usaha');
            $table->string('jumlah_kredit');
            $table->string('tujuan_kredit');
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
        Schema::dropIfExists('calon_nasabah');
    }
}
