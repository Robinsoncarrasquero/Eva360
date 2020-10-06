<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Competencia;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Competencia::class, function (Faker $faker) {
    return [
        'name'=>$faker->name(),
        'description' => $faker->text() ,
        'nivelrequerido'=>Arr::random([90,50,60])

    ];
});
