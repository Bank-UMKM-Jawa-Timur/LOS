<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataKkbToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('sppk')->nullable();
            $table->string('po')->nullable();
            $table->string('pk')->nullable();
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
        Schema::table('pengajuan', function (Blueprint $table) {
            //
        });
    }
}
