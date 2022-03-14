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
            $table->string('nama');
            $table->text('alamat_rumah');
            $table->text('alamat_usaha');
            $table->string('no_ktp',16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('status');
            $table->string('jenis_usaha');
            $table->string('jumlah_kredit');
            $table->text('tujuan_kredit');
            $table->text('jaminan_kredit');
            $table->text('hubungan_bank');
            $table->text('verifikasi_umum');
            $table->foreignId('id_user')->constrained('users');
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
