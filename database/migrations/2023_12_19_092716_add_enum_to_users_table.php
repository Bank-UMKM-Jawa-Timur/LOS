<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEnumToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Administrator','Pincab','PBO','PBP','Penyelia Kredit','Staf Analis Kredit', 'SPI', 'Kredit Umum','Direksi','Kredit Program')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Administrator','Pincab','PBO','PBP','Penyelia Kredit','Staf Analis Kredit', 'SPI', 'Kredit Umum','Direksi')");

        });
    }
}
