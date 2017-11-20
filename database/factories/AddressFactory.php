<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(RainCheck\Models\Address::class, function (Faker $faker) {
    $country = RainCheck\Models\Country::inRandomOrder()->first();
    $region = $country->subregions()->inRandomOrder()->first();

    return [
        'company' => $faker->company,
        'address1' => $faker->streetAddress,
        'address2' => null,
        'city' => $faker->city,
        'zip' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'country_id' => $country->id,
        'subregion_id' => optional($region)->id
    ];
});
