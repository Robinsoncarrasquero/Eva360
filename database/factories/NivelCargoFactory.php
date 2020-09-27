<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nivel_Cargo;
use Faker\Generator as Faker;

$factory->define(Nivel_Cargo::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->text(),
    ];
});
