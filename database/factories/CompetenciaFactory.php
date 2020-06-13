<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Competencia;
use Faker\Generator as Faker;

$factory->define(Competencia::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->name(),
        'description' => $faker->text() ,
        'tipo' => 'G',
        'nivelrequerido'=>100,

    ];
});
