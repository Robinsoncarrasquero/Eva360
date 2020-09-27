<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evaluado;
use Faker\Generator as Faker;

$factory->define(Evaluado::class, function (Faker $faker) {
    return [
        'name'=>$faker->name(),
        'word_key'=>'12345',
        'status' => 0,
    ];
});
