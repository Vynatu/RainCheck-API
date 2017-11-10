<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'countries',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('country_code', 3)->index();
            }
        );

        Schema::create(
            'subregions',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('country_id')->unsigned()->index();
                $table->string('country_code', 3)->index();
                $table->string('subregion_code', 4)->index();

                $table->unique(['country_id', 'subregion_code']);
                $table->foreign('country_id')
                      ->references('id')->on('countries')
                      ->onDelete('cascade');
            }
        );

        (new CountriesSeeder)->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subregions');
        Schema::dropIfExists('countries');
    }
}
