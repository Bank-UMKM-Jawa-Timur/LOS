<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldToTemporaryCalonNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            $table->bigInteger('id_kabupaten')->nullable()->after('id_user');
            $table->bigInteger('id_kecamatan')->nullable()->after('id_kabupaten');
            $table->bigInteger('id_desa')->nullable()->after('id_kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporary_calon_nasabah', function (Blueprint $table) {
            $table->dropColumn([
                'id_kabupaten',
                'id_kecamatan',
                'id_desa',
            ]);
        });
    }
}
