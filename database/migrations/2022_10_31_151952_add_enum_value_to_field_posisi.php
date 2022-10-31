<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnumValueToFieldPosisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE pengajuan MODIFY posisi ENUM('Proses Input Data','Review Penyelia','PBP','Pincab','Selesai','Ditolak')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_posisi', function (Blueprint $table) {
            DB::statement("ALTER TABLE pengajuan MODIFY posisi ENUM('Proses Input Data','Review Penyelia','PBP','Pincab','Selesai')");
        });
    }
}
