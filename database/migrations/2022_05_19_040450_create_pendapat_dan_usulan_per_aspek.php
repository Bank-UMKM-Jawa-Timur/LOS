<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendapatDanUsulanPerAspek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendapat_dan_usulan_per_aspek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->constrained('pengajuan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('id_staf')->nullable();
            $table->bigInteger('id_penyelia')->nullable();
            $table->bigInteger('id_pincab')->nullable();
            $table->foreignId('id_aspek')->constrained('item')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('pendapat_per_aspek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendapat_dan_usulan_per_aspek');
    }
}
