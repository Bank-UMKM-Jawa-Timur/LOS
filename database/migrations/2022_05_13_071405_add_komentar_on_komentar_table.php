<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKomentarOnKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('komentar', function (Blueprint $table) {
            $table->bigInteger('id_pincab')->nullable();
            $table->text('komentar_staff')->nullable();
            $table->bigInteger('id_staff')->nullable();
            $table->text('komentar_penyelia')->nullable();
            $table->bigInteger('id_penyelia')->nullable();
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
            $table->dropColumn('id_pincab');
            $table->dropColumn('komentar_staff');
            $table->dropColumn('id_staff');
            $table->dropColumn('komentar_penyelia');
            $table->dropColumn('id_penyelia');
        });
    }
}
