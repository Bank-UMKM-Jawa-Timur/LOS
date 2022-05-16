<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanSubColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_sub_column', function (Blueprint $table) {
            $table->id();
            $table->string('jawaban_sub_column');
            $table->foreignId('id_option')->constrained('option')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_pengajuan')->constrained('pengajuan')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('jawaban_sub_column');
    }
}
