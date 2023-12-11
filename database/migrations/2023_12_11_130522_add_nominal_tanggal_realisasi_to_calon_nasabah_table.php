<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNominalTanggalRealisasiToCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            $table->string('nominal_realisasi')
                ->nullable()
                ->after('jumlah_kredit');
            $table->integer('jangka_waktu_realisasi', false, true)
                ->nullable()
                ->after('nominal_realisasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            $table->dropColumn('nominal_realisasi');
            $table->dropColumn('jangka_waktu_realisasi');
        });
    }
}
