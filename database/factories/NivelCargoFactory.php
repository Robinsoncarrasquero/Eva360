<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NivelCargo;
use Faker\Generator as Faker;

$factory->define(NivelCargo::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->text(),
    ];
});
