<?php

use Illuminate\Database\Seeder;
use App\Frecuencia;
use Carbon\Factory as CarbonFactory;
use Faker\Factory;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class FrecuenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('frecuencias')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        factory(Frecuencia::class)->create([
            'name'=>'Siempre',
            'valor'=>100,
            'description'=>'Representa el comportamiento habitual del evaluado',
        ]);

        factory(Frecuencia::class)->create([
            'name'=>'Frecuente',
            'valor'=>75,
            'description'=>'Representa el comportamiento frecuente.',
        ]);
        factory(Frecuencia::class)->create([
            'name'=>'Medio',
            'valor'=>50,
            'description'=>'Representa el comportamiento en la mita de la veces u ocaciones.',
        ]);

        factory(Frecuencia::class)->create([
            'name'=>'Ocasional',
            'valor'=>25,
            'description'=>'Representa el comportamiento ocasional del evaluado.',
        ]);

        factory(Frecuencia::class)->create([
            'name'=>'ND',
            'valor'=>0,
            'description'=>'Deficiente necesita significativas mejoras.',
        ]);


    }
}
