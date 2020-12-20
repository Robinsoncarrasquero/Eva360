<?php

use App\Competencia;
use App\Grado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompetenciaBaseSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('competencias')->truncate();
        DB::table('grados')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $jsoncompetencias = Storage::disk('local')->get('config/seeder_competencias.json');
        $competencias=json_decode($jsoncompetencias);

        $jsongrados = Storage::disk('local')->get('config/seeder_grados.json');
        $grados=json_decode($jsongrados);

        foreach ($competencias as $key=>$data) {

            foreach($data as $kdata=>$dc)
            {
         //          dump($datacompetencia);
                // alguna otra acción

                $competencia=factory(Competencia::class)->create([
                    'name'=>$dc->name,
                    'tipo_id'=>$dc['tipo_id'],
                    'description'=>$dc['description'],
                    'nivelrequerido'=>$dc['nivelrequerido'],
                ]);

                // //Creamos Los grados de la competencias
                // foreach ($grados['data'] as $key => $value) {
                //     # code...
                //     if ($value->competencia_id == $datacompetencia->id){
                //         factory(Grado::class)->create([
                //             'grado'=>$key['grado',
                //             'ponderacion'=>$value->ponderacion,
                //             'competencia_id'=>$competencia->id,
                //             'description'=>$value->description,
                //         ]);
                //     }

                // }

            }
        }


    }
}
