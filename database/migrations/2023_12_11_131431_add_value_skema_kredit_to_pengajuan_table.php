<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueSkemaKreditToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE pengajuan MODIFY skema_kredit ENUM('PKPJ', 'KKB', 'Talangan Umroh', 'Prokesra', 'Dagulir') DEFAULT 'Prokesra'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pengajuan MODIFY skema_kredit ENUM('PKPJ', 'KKB', 'Talangan Umroh', 'Prokesra') DEFAULT 'Prokesra'");
    }
}
