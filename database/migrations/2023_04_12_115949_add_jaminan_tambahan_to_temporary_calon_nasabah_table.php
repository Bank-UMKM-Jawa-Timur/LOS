<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJaminanTambahanToTemporaryCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            $table->string('jaminan_tambahan')->nullable();
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
