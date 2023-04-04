<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_calon_nasabah', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->string('no_ktp',16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('jumlah_kredit')->nullable();
            $table->text('tujuan_kredit')->nullable();
            $table->text('jaminan_kredit')->nullable();
            $table->text('hubungan_bank')->nullable();
            $table->text('verifikasi_umum')->nullable();
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
        Schema::dropIfExists('temporary_calon_nasabah');
    }
}
