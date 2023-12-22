<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnlyAcceptToItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->string('only_accept', 50)
                ->nullable()
                ->comment('only use for input file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('only_accept');
        });
    }
}
