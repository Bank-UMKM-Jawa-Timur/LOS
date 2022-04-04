<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('posisi',['Proses Input Data','Review Penyelia','Pincab','Selesai']);
            $table->date('tanggal_review_penyelia')->nullable()->nullable();
            $table->date('tanggal_review_pincab')->nullable();
            $table->enum('status_by_sistem',['hijau','kuning','merah'])->nullable();
            $table->enum('status',['hijau','kuning','merah'])->nullable();
            $table->decimal('average_by_sistem',4,2)->nullable();
            $table->decimal('average_by_penyelia',4,2)->nullable();
            $table->integer('id_cabang')->nullable();
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
        Schema::dropIfExists('pengajuan');
    }
}
