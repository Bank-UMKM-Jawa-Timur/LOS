<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFieldDagulirToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            DB::statement("ALTER TABLE pengajuan MODIFY COLUMN `skema_kredit` enum('PKPJ','KKB','Talangan Umroh','Prokesra','Kusuma','Dagulir') DEFAULT 'Prokesra'");
            $table->unsignedBigInteger('dagulir_id')->nullable()->after('skema_limit_id');

            $table->foreign('dagulir_id')
                ->references('id')
                ->on('pengajuan_dagulir')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
