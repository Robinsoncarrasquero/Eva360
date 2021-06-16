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
        $jscompetencias=json_decode($jsoncompetencias);

        $jsongrados = Storage::disk('local')->get('config/seeder_grados.json');
        $jsgrados=json_decode($jsongrados);

        //comenzamos a recorrer el array desde la posicion 2
        foreach ($jscompetencias[2]->data as $kc=>$c){
            $seleccionmultiple=$c->id ==25 ? 1 : 0;
            $seleccionfrecuencia=$c->id ==25 ? 1 : 0;
            $new_competencia=factory(Competencia::class)->create([
                'name'=>$c->name,
                'tipo_id'=>$c->tipo_id,
                'description'=>$c->description,
                'nivelrequerido'=>$c->nivelrequerido,
                'seleccionmultiple'=>$seleccionmultiple,
                'seleccionfrecuencia'=>$seleccionfrecuencia,
            ]);

            foreach ($jsgrados[2]->data as $kg => $g) {
                # code...
                if ($g->competencia_id == $c->id){
                    factory(Grado::class)->create([
                        'grado'=>$g->grado,
                        'description'=>$g->description,
                        'ponderacion'=>$g->ponderacion,
                        'competencia_id'=>$new_competencia->id,
                    ]);
                }

            }
        }

    }
}
