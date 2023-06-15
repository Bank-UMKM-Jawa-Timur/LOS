<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdStafFieldToPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->bigInteger('id_staf', false, true)->nullable()->after('progress_pengajuan_data');
            $table->bigInteger('id_penyelia', false, true)->nullable()->after('id_staf');
            $table->bigInteger('id_pbo', false, true)->nullable()->after('tanggal_review_penyelia');
            $table->bigInteger('id_pbp', false, true)->nullable()->after('tanggal_review_pbo');
            $table->bigInteger('id_pincab', false, true)->nullable()->after('tanggal_review_pbp');

            $table->foreign('id_staf')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_penyelia')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_pbo')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_pbp')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_pincab')->references('id')->on('users')->cascadeOnDelete();
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
            $table->dropForeign('pengajuan_id_staf_foreign');
            $table->dropForeign('pengajuan_id_penyelia_foreign');
            $table->dropForeign('pengajuan_id_pbo_foreign');
            $table->dropForeign('pengajuan_id_pbp_foreign');
            $table->dropForeign('pengajuan_id_pincab_foreign');
            $table->dropColumn('id_staf');
            $table->dropColumn('id_penyelia');
            $table->dropColumn('id_pbo');
            $table->dropColumn('id_pbp');
            $table->dropColumn('id_pincab');
        });
    }
}
