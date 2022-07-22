<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeontableitem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('option', function (Blueprint $table) {
            $table->dropForeign('option_id_item_foreign');
            // $table->dropColumn('pick_detail_id');
            $table->foreign('id_item')->references('id')->on('item')->onDelete('cascade');
        });
        
        Schema::table('jawaban', function (Blueprint $table) {
            $table->dropForeign('jawaban_id_jawaban_foreign');
            // $table->dropColumn('pick_detail_id');
            $table->foreign('id_jawaban')->references('id')->on('option')->onDelete('cascade');
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
