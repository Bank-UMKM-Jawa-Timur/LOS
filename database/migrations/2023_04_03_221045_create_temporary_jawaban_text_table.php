<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryJawabanTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_jawaban_text', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_calon_nasabah_temporary')->constrained('temporary_calon_nasabah');
            $table->foreignId('id_jawaban')->constrained('item')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('opsi_text')->nullable();
            $table->integer('skor_penyelia')->nullable();
            $table->integer('skor')->nullable();
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
        Schema::dropIfExists('temporary_jawaban_text');
    }
}
