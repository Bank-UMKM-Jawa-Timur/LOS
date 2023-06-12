<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPboToKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->text('komentar_pbo')->nullable();
            $table->bigInteger('id_pbo', false, true)->nullable();
            
            $table->foreign('id_pbo')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->dropColumn('komentar_pbo');
            $table->dropForeign('komentar_id_pbo_foreign');
            $table->dropColumn('id_pbo');
        });
    }
}
