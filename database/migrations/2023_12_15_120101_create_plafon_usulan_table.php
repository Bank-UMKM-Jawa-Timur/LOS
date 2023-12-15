<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlafonUsulanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plafon_usulan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengajuan');
            $table->integer('plafon_usulan_penyelia')->nullable();
            $table->integer('jangka_waktu_usulan_penyelia')->nullable();
            $table->integer('plafon_usulan_pbo')->nullable();
            $table->integer('jangka_waktu_usulan_pbo')->nullable();
            $table->integer('plafon_usulan_pbp')->nullable();
            $table->integer('jangka_waktu_usulan_pbp')->nullable();
            $table->integer('plafon_usulan_pincab')->nullable();
            $table->integer('jangka_waktu_usulan_pincab')->nullable();
            $table->timestamps();

            $table->foreign('id_pengajuan')
                ->references('id')
                ->on('pengajuan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plafon_usulan');
    }
}
