<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlasanPengembalianDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alasan_pengembalian_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pengajuan', false, true);
            $table->bigInteger('id_user', false, true);
            $table->enum('dari', ['Review Penyelia','PBO','PBP','Pincab']);
            $table->enum('ke', ['Proses Input Data', 'Review Penyelia','PBO','PBP','Pincab']);
            $table->text('alasan');
            $table->timestamps();

            $table->foreign('id_pengajuan')->references('id')->on('pengajuan')->cascadeOnDelete();
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alasan_pengembalian_data');
    }
}
