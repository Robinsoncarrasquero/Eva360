<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubMeta;
use Faker\Generator as Faker;

$factory->define(SubMeta::class, function (Faker $faker) {
    return [
        'submeta'=>'1',
        'requerido'=>100,
        'meta_id'=>1,
        'description' => $faker->text() ,
    ];
});
