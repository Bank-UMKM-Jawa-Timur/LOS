<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataKkbToTemporaryCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            $table->enum('skema_kredit', ['PKPJ', 'KKB', 'Talangan Umroh', 'Prokesra', 'Kusuma'])->default('Prokesra');
            $table->string('tipe_loan')->nullable();
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
