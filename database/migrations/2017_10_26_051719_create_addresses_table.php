<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'addresses',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->index();
                $table->string('company')->nullable();
                $table->string('address1');
                $table->string('address2')->nullable();
                $table->string('zip');
                $table->string('phone')->nullable();
                $table->integer('country_id')->unsigned();
                $table->integer('subregion_id')->unsigned()->nullable();

                $table->timestamps();

                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
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
        Schema::dropIfExists('addresses');
    }
}
