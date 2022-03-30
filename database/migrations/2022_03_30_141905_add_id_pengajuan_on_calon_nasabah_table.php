<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPengajuanOnCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
           $table->foreignId('id_pengajuan')->constrained('pengajuan')->after('id_user');
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
            $table->dropColumn('id_pengajuan');
        });
    }
}
