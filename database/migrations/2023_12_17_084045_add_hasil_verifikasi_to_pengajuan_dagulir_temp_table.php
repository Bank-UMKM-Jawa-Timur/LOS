<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasilVerifikasiToPengajuanDagulirTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_dagulir_temp', function (Blueprint $table) {
            $table->string('foto_nasabah')->after('email')->nullable();
            $table->unsignedBigInteger('desa_id')->nullable();
            $table->unsignedBigInteger('desa_ktp')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('hasil_verifikasi')->nullable();
            $table->string('foto_pasangan')->nullable();
            $table->string('nik_pasangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_dagulir_temp', function (Blueprint $table) {
        });
    }
}
