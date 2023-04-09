<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdNasabahOnTemporaryJawabanTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_jawaban_text', function(Blueprint $table) {
            $table->dropConstrainedForeignId('id_calon_nasabah_temporary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporary_jawaban_text', function(Blueprint $table) {
            $table->foreignId('id_calon_nasabah_temporary')->constrained('temporary_calon_nasabah');
        });
    }
}
