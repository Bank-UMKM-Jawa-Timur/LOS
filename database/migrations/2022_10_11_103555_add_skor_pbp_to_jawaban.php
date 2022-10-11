<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkorPbpToJawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jawaban', function (Blueprint $table) {
            $table->integer('skor_pbp')->nullable()->after('skor_penyelia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jawaban', function (Blueprint $table) {
            $table->dropColumn('skor_pbp');
        });
    }
}
