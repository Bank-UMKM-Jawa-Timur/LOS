<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPboRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Administrator','Pincab','PBO','PBP','Penyelia Kredit','Staf Analis Kredit')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Administrator','Pincab','PBP','Penyelia Kredit','Staf Analis Kredit')");
    }
}
