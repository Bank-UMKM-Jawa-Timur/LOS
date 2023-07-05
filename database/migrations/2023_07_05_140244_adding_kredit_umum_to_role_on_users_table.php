<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingKreditUmumToRoleOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role enum('Administrator','Pincab','PBO','PBP','Penyelia Kredit','Staf Analis Kredit', 'SPI', 'Kredit Umum')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role enum('Administrator','Pincab','PBO','PBP','Penyelia Kredit','Staf Analis Kredit', 'SPI')");
    }
}
