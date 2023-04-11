<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCalonNasabahToJawabanTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jawaban_temp', function (Blueprint $table) {
            $table->foreignId('id_temporary_calon_nasabah')
                ->after('id')
                ->constrained('temporary_calon_nasabah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jawaban_temp', function (Blueprint $table) {
            //
        });
    }
}
