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
            'name'=>'Frecuentemente',
            'valor'=>100,
        ]);

        factory(Frecuencia::class)->create([
            'name'=>'Siempre',
            'valor'=>75,
        ]);
        factory(Frecuencia::class)->create([
            'name'=>'Medio',
            'valor'=>50,
        ]);

        factory(Frecuencia::class)->create([
            'name'=>'Ocacionalmente',
            'valor'=>25,
        ]);


    }
}
