<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeFieldOnDataPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_po', function(Blueprint $table) {
            $table->dropForeign('data_po_id_type_foreign');
            $table->dropColumn('id_type');
            $table->string('merk', 50)->after('id_pengajuan');
            $table->string('tipe', 50)->after('merk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_po', function(Blueprint $table) {
            $table->dropColumn('merk');
            $table->dropColumn('tipe');
            $table->bigInteger('id_type')->after('id_pengajuan');
            $table->foreign('id_type')->references('id')->on('mst_tipe')->cascadeOnDelete();
        });
    }
}
