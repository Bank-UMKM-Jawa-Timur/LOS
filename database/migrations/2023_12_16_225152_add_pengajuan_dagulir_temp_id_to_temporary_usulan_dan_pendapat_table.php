<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddPengajuanDagulirTempIdToTemporaryUsulanDanPendapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_usulan_dan_pendapat', function (Blueprint $table) {
            DB::statement("ALTER TABLE temporary_usulan_dan_pendapat MODIFY id_temp bigint unsigned null");
            $table->unsignedBigInteger('temporary_dagulir_id')->nullable();

            $table->foreign('id_temp')
                ->references('id')
                ->on('temporary_calon_nasabah')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('temporary_dagulir_id')
                ->references('id')
                ->on('pengajuan_dagulir_temp')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporary_usulan_dan_pendapat', function (Blueprint $table) {
            //
        });
    }
}
