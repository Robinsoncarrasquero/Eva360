<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evaluador;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Evaluador::class, function (Faker $faker) {
    return [
        'name'=>$faker->name(),
        'email' => $faker->email(),
        'relation' => 'Super',
        'status' => 2,
        'remember_token' => Str::random(32),


    ];
});
