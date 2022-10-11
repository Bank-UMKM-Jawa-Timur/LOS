<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPbpOnPendapatDanUsulanPerAspekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendapat_dan_usulan_per_aspek', function (Blueprint $table) {
            $table->bigInteger('id_pbp')->nullable()->after('id_pincab');
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
            $table->dropColumn('id_pbp');
        });
    }
}
