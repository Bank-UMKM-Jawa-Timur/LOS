<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeOnTemporaryJawabanText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_jawaban_text', function(Blueprint $table) {
            $table->enum('type', ['file', 'text'])
                ->default('text')
                ->after('skor');
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
            $table->dropColumn('type');
        });
    }
}
