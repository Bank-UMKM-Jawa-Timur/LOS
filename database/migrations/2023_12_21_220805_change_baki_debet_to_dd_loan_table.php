<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeBakiDebetToDdLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dd_loan', function (Blueprint $table) {
            DB::statement('ALTER TABLE dd_loan MODIFY baki_debet DOUBLE(12,0)');
            // $table->double('baki_debet',12,0,true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dd_loan', function (Blueprint $table) {
            //
        });
    }
}
