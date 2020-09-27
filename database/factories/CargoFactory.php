<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cargo;
use Faker\Generator as Faker;

$factory->define(Cargo::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->text(),
    ];
});
