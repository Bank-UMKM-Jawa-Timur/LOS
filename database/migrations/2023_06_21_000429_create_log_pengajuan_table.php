<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pengajuan', false, true);
            $table->text('activity');
            $table->bigInteger('user_id', false, true);
            $table->string('nip', 20);
            $table->timestamps();

            $table->foreign('id_pengajuan')->references('id')->on('pengajuan')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_pengajuan');
    }
}
