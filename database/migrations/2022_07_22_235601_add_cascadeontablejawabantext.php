<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeontablejawabantext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jawaban_text', function (Blueprint $table) {
            $table->dropForeign('jawaban_text_id_jawaban_foreign');
            // $table->dropColumn('pick_detail_id');
            $table->foreign('id_jawaban')->references('id')->on('item')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
