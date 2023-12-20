<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeFromAppsValueToPengajuanDagulirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE pengajuan_dagulir CHANGE `from_apps` `from_apps` ENUM('pincetar', 'sipde') null");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE pengajuan_dagulir CHANGE `from_apps` `from_apps` ENUM('pincetar', 'dagulir') null");
    }
}
