<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Evaluacion;
use Illuminate\Support\Arr;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('evaluaciones')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS


        //Evaluador
        for ($xevaluador=1; $xevaluador <21 ; $xevaluador++) {
            $this->add_evaluacion($xevaluador);
        }


    }

    public function add_evaluacion($evaluador){

       //Creamos una evaluacion
       for ($i=1; $i <5 ; $i++) {
            $competencia=$i;
            $this->add_competencia($evaluador,$competencia);
       }


    }

    /** Obtenemos los resultados de la prueba en una array */
    public function prueba()
    {
        $grado=Arr::random(['A','B','C','D']);
        $pondera=Arr::get(['A'=>100,'B'=>75,'C'=>50,'D'=>25],$grado);
        $frecuencia=Arr::random(['A'=>100,'B'=>75,'C'=>50,'D'=>25]);
        $resultado=$pondera * $frecuencia /100;
        return ['grado'=>$grado,'ponderacion'=>$pondera,'frecuencia'=>$frecuencia,'resultado'=>$resultado];
    }
    /** Generamos las competencias de cada evaluador */
    public function add_competencia($evaluador,$competencia)
    {
        # code...
       $prueba= $this->prueba();
       $eva1 = factory(Evaluacion::class)->create([
            'competencia_id' => $competencia,
            'evaluador_id'=>$evaluador,
            'grado'=>Arr::get($prueba,'grado'),
            'ponderacion'=>Arr::get($prueba,'ponderacion'),
            'frecuencia'=>Arr::get($prueba,'frecuencia'),
            'resultado'=>Arr::get($prueba,'resultado'),
        ]);
    }


}
