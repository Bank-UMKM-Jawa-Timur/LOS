<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeSkemaKreditNullableToTemporaryCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            DB::statement("ALTER TABLE temporary_calon_nasabah CHANGE `skema_kredit` `skema_kredit` ENUM('PKPJ', 'KKB', 'Talangan Umroh', 'Prokesra', 'Kusuma') null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            //
        });
    }
}
