<?php

use App\Modelo;
use App\ModeloCompetencia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloSeeder extends Seeder
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

        DB::table('modelos_competencias')->truncate();
        DB::table('modelos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

           //GENERAL
        $modelo=factory(Modelo::class)->create([
            'name'=>'Talento Base',
        ]);

        for ($i=1; $i <5 ; $i++) {
            factory(ModeloCompetencia::class)->create([
                'competencia_id'=>$i,
                'modelo_id'=>$modelo,
            ]);
        }

    }
}
