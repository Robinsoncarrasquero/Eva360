<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modelo;
use Faker\Generator as Faker;

$factory->define(Modelo::class, function (Faker $faker) {
    return [
        'name'=>$faker->name(),
        'description' => $faker->text() ,
    ];
});
