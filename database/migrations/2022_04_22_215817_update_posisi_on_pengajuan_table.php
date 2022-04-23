<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdatePosisiOnPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // $table->enum('posisi',['Proses Input Data','Review Penyelia','Pincab','Selesai','Ditolak'])->change();
            DB::statement("ALTER TABLE pengajuan MODIFY COLUMN posisi ENUM('Proses Input Data','Review Penyelia','Pincab','Selesai','Ditolak')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            //
        });
    }
}
