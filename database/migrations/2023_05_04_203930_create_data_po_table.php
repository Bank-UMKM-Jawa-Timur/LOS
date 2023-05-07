<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_po', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->constrained('pengajuan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_type')->constrained('mst_tipe')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tahun_kendaraan', 4)->nullable();
            $table->string('warna', 25)->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('jumlah');
            $table->integer('harga')->nullable();
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
        Schema::dropIfExists('data_po');
    }
}
