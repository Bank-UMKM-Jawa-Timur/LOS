<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanceledAtToPengajuanDagulirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_dagulir', function (Blueprint $table) {
            $table->timestamp('canceled_at')
                ->nullable()
                ->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_dagulir', function (Blueprint $table) {
            $table->dropColumn('canceled_at');
        });
    }
}
