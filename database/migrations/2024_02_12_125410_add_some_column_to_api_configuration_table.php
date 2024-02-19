<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToApiConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_configuration', function (Blueprint $table) {
            $table->string('url_callback')->nullable()->after('sipde_password');
            $table->string('oauth_app_id')->nullable()->after('url_callback');
            $table->string('oauth_app_secret')->nullable()->after('oauth_app_id');
            $table->string('oauth_authority')->nullable()->after('oauth_app_secret');
            $table->string('oauth_authorize_endpoint')->nullable()->after('oauth_authority');
            $table->string('oauth_token_endpoint')->nullable()->after('oauth_authorize_endpoint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_configuration', function (Blueprint $table) {
            //
        });
    }
}
