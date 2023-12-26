<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldBadeToDdAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dd_angsuran', function (Blueprint $table) {
            $table->renameColumn('baki_debet', 'pokok_angsuran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dd_angsuran', function (Blueprint $table) {
            $table->renameColumn('pokok_angsuran', 'baki_debet');
        });
    }
}
