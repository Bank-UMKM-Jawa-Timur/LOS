<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dd_loan', function (Blueprint $table) {
            $table->id();
            $table->string('no_loan');
            $table->string('kode_pendaftaran');
            $table->double('plafon', 12, 0, true);
            $table->tinyInteger('jangka_waktu', false, true)
                    ->comment('Jangka waktu dalam bulan');
            $table->double('baki_debet',12,9,true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dd_loan');
    }
}
