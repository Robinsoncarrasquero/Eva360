<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evaluacion;
use Faker\Generator as Faker;

$factory->define(Evaluacion::class, function (Faker $faker) {
    return [
        'competencia_id' => 1,
        'evaluador_id'=>1,
        'grado'=>'A',
        'ponderacion'=>100,
        'frecuencia'=>100,
        'resultado'=>100,
    ];
});
