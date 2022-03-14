<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDaerahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_nasabah', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kabupaten')->after('id_user');

            $table->foreign('id_kabupaten')->references('id')->on('kabupaten');

            $table->unsignedBigInteger('id_kecamatan')->after('id_kabupaten');

            $table->foreign('id_kecamatan')->references('id')->on('kecamatan');

            $table->unsignedBigInteger('id_desa')->after('id_kecamatan');

            $table->foreign('id_desa')->references('id')->on('desa');

            // $table->foreignId('id_kabupaten')->constrained()->after('id_user');
            // $table->foreignId('id_kecamatan')->constrained('kecamatan')->after('id_kabupaten');
            // $table->foreignId('id_desa')->constrained('desa')->after('id_kecamatan');
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
            $table->dropColumn(['id_kabupaten','id_kecamatan','id_desa']);
        });
    }
}
