<?php

use App\Medida;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('medidas')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        factory(Medida::class)->create([
            'name'=>'USD',
            'description'=>'Dolares Americanos',
            'medida'=>'USD',

        ]);

        factory(Medida::class)->create([
            'name'=>'EUR',
            'description'=>'Euros Europa',
            'medida'=>'EUR',

        ]);

        factory(Medida::class)->create([
            'name'=>'MXN',
            'description'=>'Pesos Mexico',
            'medida'=>'MXN',
        ]);

        factory(Medida::class)->create([
            'name'=>'BS',
            'description'=>'Bolivares Venezuela',
            'medida'=>'BS',
        ]);

        factory(Medida::class)->create([
            'name'=>'HRS',
            'description'=>'Horas',
            'medida'=>'HRS',
        ]);

        factory(Medida::class)->create([
            'name'=>'SEM',
            'description'=>'Semanas',
            'medida'=>'SEM',
        ]);

        factory(Medida::class)->create([
            'name'=>'MESES',
            'description'=>'Meses',
            'medida'=>'MESES',
        ]);

        factory(Medida::class)->create([
            'name'=>'DIAS',
            'description'=>'Dias',
            'medida'=>'DIAS',
        ]);

        factory(Medida::class)->create([
            'name'=>'TON',
            'description'=>'Toneladas',
            'medida'=>'TON',
        ]);

        factory(Medida::class)->create([
            'name'=>'KG',
            'description'=>'Kilos',
            'medida'=>'KG',
        ]);


    }
}
