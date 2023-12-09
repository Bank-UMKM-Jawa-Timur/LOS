<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPengajuanDagulirIdToPendapatDanUsulanPerAspekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendapat_dan_usulan_per_aspek', function (Blueprint $table) {
            $table->bigInteger('id_pengajuan', false, true)->nullable()->change();
            $table->foreignId('pengajuan_dagulir_id')
                    ->nullable()
                    ->after('id_pengajuan')
                    ->constrained('pengajuan_dagulir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendapat_dan_usulan_per_aspek', function (Blueprint $table) {
            $table->bigInteger('id_pengajuan', false, true)->nullable(false)->change();
            $table->dropForeign('pendapat_dan_usulan_per_aspek_pengajuan_dagulir_id_foreign');
            $table->dropColumn('pengajuan_dagulir_id');
        });
    }
}
