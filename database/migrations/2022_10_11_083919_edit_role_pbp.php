<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditRolePbp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `users` CHANGE `role` `role` ENUM('Administrator','Pincab','PBP','Penyelia Kredit','Staf Analis Kredit')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `users` CHANGE `role` `role` ENUM('Administrator','Pincab','Penyelia Kredit','Staf Analis Kredit')");
    }
}
