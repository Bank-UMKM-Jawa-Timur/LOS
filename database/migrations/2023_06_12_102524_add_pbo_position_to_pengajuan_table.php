<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPboPositionToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE pengajuan MODIFY COLUMN posisi ENUM('Proses Input Data','Review Penyelia','PBO','PBP','Pincab','Selesai','Ditolak')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE pengajuan MODIFY COLUMN posisi ENUM('Proses Input Data','Review Penyelia','PBP','Pincab','Selesai','Ditolak')");
    }
}
