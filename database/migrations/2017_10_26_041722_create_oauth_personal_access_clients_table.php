<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_personal_access_clients',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('client_id')->index();
                $table->timestamps();

                $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_personal_access_clients');
    }
}
