<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_text', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->constrained('pengajuan');
            $table->foreignId('id_jawaban')->constrained('option')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('jawaban_text');
    }
}
