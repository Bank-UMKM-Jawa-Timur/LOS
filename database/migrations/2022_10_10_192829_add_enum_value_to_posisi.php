<?php

use App\Models\PengajuanModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnumValueToPosisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE pengajuan MODIFY posisi ENUM('Proses Input Data','Review Penyelia','PBP','Pincab','Selesai')");
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE pengajuan MODIFY posisi ENUM('Proses Input Data','Review Penyelia','Pincab','Selesai')");
    }
}
