<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ResultadosController extends Controller
{

    public function resultados($evaluado_id)
    {
        $title="Resultados";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);
        $evaluadores = $evaluado->evaluadores;

       return \view('resultados.evaluacion',compact("evaluado","evaluadores","title"));
    }
    /**
     * Obtenemos los resultados finales de la prueba
     */
    public function resumidos($evaluado_id)
    {
        $title="Finales";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $competencias = $this->sqldata($evaluado_id);
        return \view('resultados.finales',compact("evaluado","competencias","title"));

    }

    //Generamos la data para la grafica
    public function graficas($evaluado_id)
    {
        $title="Finales";

        //Obtenemos los evaluadores del evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $competencias = $this->sqldata($evaluado_id);

        foreach ($competencias as $key => $value) {

            $arrayCategoria[]=$value['competencia'];
            $arrayNivel[]=(int) $value['nivelRequerido'];
            $arrayEvaluacion[]=$value['eva360'];

            //Creamos una array con la data de los evaluadores
            foreach ($value['data'] as $item) {
                $arrayEvaluador[] =['name'=> $item['name'],'average'=>$item['average']];

            }
        }

        $collection= collect($arrayEvaluador);
        //Agrupamos la data de evaluadores para obtener una coleccion
        $evagrouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['average']];
        });
        //filtramos para un solo grupo de evaluadores
        // $relation='Boss';
        // $filtro = $evagrouped->reject(function ($item, $key) use ($relation){
        //     return  $key!=$relation ;
        // });

        //Creamos un array con la data de cada serie
        $dataSerie=[];
        $dataSerie[]= ['name'=>'Nivel Requerido','data'=>$arrayNivel];

        foreach ($evagrouped as $key => $value) {
            $data=$value;
            $dataSerie[]=['name'=>$key,'data'=>$data];
            $datax[]=['name'=>$key,'data'=>$data];

        }
        $dataSerie[]= ['name'=>'Eva360','data'=>$arrayEvaluacion];
        $dataCategoria=$arrayCategoria;

        return \view('resultados.charteva360',compact("dataSerie","dataCategoria","title","evaluado"));
    }

    //Obtenemos la data sql de los resultados grupadas por competencia y relacion
    private function sqldata($evaluado_id){

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::findOrFail($evaluado_id);

        $evaluadores = $evaluado->evaluadores;
        $whereIn=$evaluadores->pluck('id');

        $competencias = DB::table('evaluaciones')
        ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
        ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
        ->select('competencias.name','evaluadores.relation','competencias.nivelrequerido',
         DB::raw('AVG(resultado) as average'))
        ->whereIn('evaluador_id',$whereIn)
        ->groupBy('competencias.name','relation','competencias.nivelrequerido')
        ->orderByRaw('competencias.name')
        ->get();

        //recibimos un objeto sdtClass y lo convertimos a un arreglo manipulable
        $dataArray = json_decode(json_encode($competencias), true);
        $collection= collect($dataArray);
        //Agrupamos la coleccion por nombre de competencia
        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name'] => [$item['average'],$item['relation'],$item['nivelrequerido']]];
        });

        //Creamos un arreglo desde la coleccion agrupada para reorganizar la informacion por competencia
        $adata=[];
        foreach ($grouped as $key => $value) {

            $sumaAverage=0;
            $evaluador=[];
            $nivelRequerido=0;

            foreach ($value as $item) {
                $evaluador[] = ['name'=>$item[1],'average'=>$item[0]];
                $sumaAverage += $item[0];
                $nivelRequerido=$item[2];
            }
            $adata[]=
            [
                'competencia'=>$key,'eva360'=>$sumaAverage/$value->count(),
                'nivelRequerido'=>$nivelRequerido,'data'=>$evaluador
            ];

        }

        return collect($adata);
    }


}
