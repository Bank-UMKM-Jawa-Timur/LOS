<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_komentar')->constrained('komentar');
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_item')->constrained('item');
            $table->text('komentar');
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
        Schema::dropIfExists('detail_komentar');
    }
}
