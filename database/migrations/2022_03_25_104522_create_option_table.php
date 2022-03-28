<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_item')->constrained('item')->nullOnDelete(true);
            $table->unsignedBigInteger('id_item');
            $table->foreign('id_item')->references('id')->on('item')->onDelete('restrict')->onUpdate('cascade');
            $table->string('option');
            $table->integer('skor');
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
        Schema::dropIfExists('option');
    }
}
