<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_configuration', function (Blueprint $table) {
            $table->id();
            $table->string('hcs_host')->nullable();
            $table->string('dwh_host')->nullable();
            $table->string('dwh_store_kredit_api_url')->nullable();
            $table->string('dwh_token')->nullable();
            $table->string('sipde_host')->nullable();
            $table->string('sipde_username')->nullable();
            $table->string('sipde_password')->nullable();
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
        Schema::dropIfExists('api_configuration');
    }
}
