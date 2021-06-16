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

        //Evaluadores
        for ($xevaluador=1; $xevaluador <41 ; $xevaluador++) {
            $this->add_evaluacion($xevaluador);
        }


    }

    /** Creamos la evaluacion por evaluador*/
    public function add_evaluacion($evaluador){

        for ($i=1; $i <5 ; $i++) {
            $competencia=Competencia::find($i);
            $this->add_competencia($evaluador,$competencia);
        }

    }

    /** Obtenemos los resultados de la condu$conducta en una array */
    public function conducta($findgrado)
    {

        $grado=Arr::random(['A','B','C','D']);
        $gradofinal=Arr::get(['A'=>100,'B'=>75,'C'=>50,'D'=>25],$findgrado);
        //$gradofinal=Arr::get(['A'=>$nivel*1,'B'=>$nivel*0.75,'C'=>$nivel*0.50,'D'=>$nivel*0.25],$grado);

        $xyz=Arr::random(['A','B','C','D']);
        //$frecuencia=Arr::get(['A'=>100,'B'=>75,'C'=>50,'D'=>25],$xyz);
        $frecuencia=Arr::random(['A'=>100,'B'=>100,'C'=>100,'D'=>100]);

        $resultado=round($gradofinal *  $frecuencia /100,2);
        return ['grado'=>$grado,'ponderacion'=>$gradofinal,'frecuencia'=>$frecuencia,'resultado'=>$resultado];
    }

    /** Generamos las competencias de cada evaluador */
    public function add_competencia($evaluador,Competencia $competencia)
    {
        # code...
       $evaluacion = factory(Evaluacion::class)->create([
            'competencia_id' => $competencia,
            'evaluador_id'=>$evaluador,
        ]);

        $this->add_comportamientos($evaluacion,$competencia);
   }

    /** Generamos los comportamientos de cada competencia */
    public function add_comportamientos(Evaluacion $evaluacion,Competencia $competencia)
    {

        $grados = Grado::where('competencia_id',$competencia->id)->get();

        $modelkeys=$grados->modelKeys();
        $gradokey=collect($modelkeys);
        $grado_id=$gradokey->random();

        foreach ($grados as $grado) {
            $conducta= $this->conducta($grado->grado);
            $ponderacion=0;
            $frecuencia=0;
            $resultado=0;
            if ($grado->id==$grado_id || $competencia->seleccionmultiple){
                $ponderacion=Arr::get($conducta,'ponderacion');
                $frecuencia=Arr::get($conducta,'frecuencia');
                $resultado=Arr::get($conducta,'resultado');
            }
            factory(Comportamiento::class)->create([
                'evaluacion_id' => $evaluacion->id,
                'grado_id'=>$grado->id,
                'ponderacion'=>$ponderacion,
                'frecuencia'=>$frecuencia,
                'resultado'=>$resultado,
            ]);
        }

        $evaluacion->resultado= $competencia->seleccionmultiple ? $evaluacion->comportamientos->avg('resultado') : $evaluacion->comportamientos->sum('resultado');
        $evaluacion->save();
    }


}
