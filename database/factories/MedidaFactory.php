<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Medida;
use Faker\Generator as Faker;

$factory->define(Medida::class, function (Faker $faker) {
    return [
        'name'=>'USD',
        'medida'=>'USD',
        'description' => $faker->text() ,
    ];
});
