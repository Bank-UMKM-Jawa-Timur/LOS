<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddValueKusumaSkemaKreditToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            DB::statement("ALTER TABLE pengajuan MODIFY COLUMN `skema_kredit` enum('PKPJ','KKB','Talangan Umroh','Prokesra','Kusuma','Dagulir') DEFAULT 'Prokesra'");
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
            DB::statement("ALTER TABLE pengajuan MODIFY COLUMN `skema_kredit` enum('PKPJ','KKB','Talangan Umroh','Prokesra','Kusuma','Dagulir') DEFAULT 'Prokesra'");
        });
    }
}
