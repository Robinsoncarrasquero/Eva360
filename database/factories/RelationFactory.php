<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Relation;
use Faker\Generator as Faker;

$factory->define(Relation::class, function (Faker $faker) {
    return [
        //
        'relation'=>$faker->name,

    ];
});
