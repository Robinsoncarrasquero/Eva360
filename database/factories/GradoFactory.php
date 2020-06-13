<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grado;
use Faker\Generator as Faker;

$factory->define(Grado::class, function (Faker $faker) {
    return [
        'description' => $faker->text() ,
        'competencia_id'=>1,

        //
    ];
});
