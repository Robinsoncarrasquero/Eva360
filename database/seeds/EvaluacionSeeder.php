<?php

use App\Competencia;
use App\Comportamiento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Evaluacion;
use App\Grado;
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
        DB::table('comportamientos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS


        //Evaluador
        for ($xevaluador=1; $xevaluador <41 ; $xevaluador++) {
            $this->add_evaluacion($xevaluador);
        }


    }

    public function add_evaluacion($evaluador){

        //$this->call(CompetenciaBaseSeeeder::class);

       //Creamos una evaluacion
       for ($i=1; $i <5 ; $i++) {
            $competencia=Competencia::find($i);

            $this->add_competencia($evaluador,$competencia);
       }



    }

    /** Obtenemos los resultados de la prueba en una array */
    public function prueba($nivel)
    {
       // $nivel=75;
        $grado=Arr::random(['A','B','C','D']);
        //$gradofinal=Arr::get(['A'=>100,'B'=>75,'C'=>100,'D'=>100],$grado);
        $gradofinal=Arr::get(['A'=>$nivel*1,'B'=>$nivel*0.75,'C'=>$nivel*0.50,'D'=>$nivel*0.25],$grado);

        //$frecuencia=Arr::random(['A'=>100,'B'=>100,'C'=>75,'D'=>75]);
        $xyz=Arr::random(['A','B','C','D']);
        $frecuencia=Arr::get(['A'=>100,'B'=>75,'C'=>50,'D'=>25],$xyz);
        $pondera= $gradofinal;
        $resultado=round($pondera *  $frecuencia /100,2);
        return ['grado'=>$grado,'ponderacion'=>$pondera,'frecuencia'=>$frecuencia,'resultado'=>$resultado];
    }
    /** Generamos las competencias de cada evaluador */
    public function add_competencia($evaluador,Competencia $competencia)
    {
        # code...
       $evaluacion = factory(Evaluacion::class)->create([
            'competencia_id' => $competencia,
            'evaluador_id'=>$evaluador,
        ]);

        $this->add_comportamiento($evaluacion,$competencia);


    }

    /** Generamos los comportamientos de las competencias a evaluar */
    public function add_comportamiento(Evaluacion $evaluacion,Competencia $competencia)
    {

        $prueba= $this->prueba($competencia->nivelrequerido);

        $grados = Grado::where('competencia_id',$competencia->id)->get();

        foreach ($grados as $grado) {
            factory(Comportamiento::class)->create([
                'evaluacion_id' => $evaluacion->id,
                'grado_id'=>$grado->id,
                'ponderacion'=>Arr::get($prueba,'ponderacion'),
                'frecuencia'=>Arr::get($prueba,'frecuencia'),
                'resultado'=>Arr::get($prueba,'resultado'),
            ]);
        }

        $evaluacion->resultado= $evaluacion->comportamientos->avg('resultado');
        $evaluacion->save();
    }


}
