<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Meta;
use Faker\Generator as Faker;

$factory->define(Meta::class, function (Faker $faker) {
    return [
        'name'=>'Ventas cobradas',
        'tipo_id'=>1,
        'nivelrequerido'=>75,
        'description' => $faker->text() ,
    ];
});
