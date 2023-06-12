<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPboToPendapatDanUsulanPerAspekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendapat_dan_usulan_per_aspek', function (Blueprint $table) {
            $table->bigInteger('id_pbo', false, true)->nullable()->after('id_penyelia');
            $table->foreign('id_pbo')->references('id')->on('users')->cascadeOnDelete();
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
            $table->dropForeign('pendapat_dan_usulan_per_aspek_id_pbo_foreign');
            $table->dropColumn('id_pbo');
        });
    }
}
