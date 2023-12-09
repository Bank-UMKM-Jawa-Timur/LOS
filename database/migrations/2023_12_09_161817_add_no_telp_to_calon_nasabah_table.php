<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoTelpToCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            $table->string('no_telp',15)->nullable()->after('no_ktp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            //
        });
    }
}
