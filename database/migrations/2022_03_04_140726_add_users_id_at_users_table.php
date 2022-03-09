<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersIdAtUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            // $table->bigInteger('id_cabang')->after('role')->nullable();
            $table->foreignId('id_users')->after('tujuan_kredit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            $table->dropColumn('id_users');
        });

    }
}
