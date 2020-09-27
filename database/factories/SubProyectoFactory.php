<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubProyecto;
use Faker\Generator as Faker;

$factory->define(SubProyecto::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->text(),
    ];
});
