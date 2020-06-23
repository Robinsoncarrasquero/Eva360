<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResultadosController extends Controller
{

    public function resultados($evaluado_id)
    {
        $title="Resultados";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);
        $evaluadores = $evaluado->evaluadores;

       return \view('resultados.resultadosevaluador',compact("evaluado","evaluadores","title"));

    }
    /**
     * Obtenemos los resultados finales de la prueba
     */
    public function resumidos($evaluado_id)
    {
        $title="Finales";

        $title="Finales";
        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $adatacollection = $this->sqldata($evaluado_id);
        $competencias= collect($adatacollection);
//        $competencias= collect($adatacollection);

        return \view('resultados.resumidos',compact("evaluado","competencias","title"));


    }

    public function graficas($evaluado_id)
    {
        $title="Finales";
        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $adatacollection = $this->sqldata($evaluado_id);
        $competencias= collect($adatacollection);

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
        //Agrupamos la data de evaluadores para obtener una coleccion agrupa
        $evagrouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['average']];
        });

        //Creamos un array con la data de cada serie para crear el patron de datos de la grafica
        $dataSerie=[];
        foreach ($evagrouped as $key => $value) {
            $dataSerie[]=['name'=>$key,'data'=>$value];
        }

        $dataSerie[]= ['name'=>'Nivel Requerido','data'=>$arrayNivel];
        $dataSerie[]= ['name'=>'Eva360','data'=>$arrayEvaluacion];

        //Lo convertimos en un json para pasarlo a la vista
        $dataCategoria=$arrayCategoria;

        return \view('resultados.charteva360',compact("dataSerie","dataCategoria","title","evaluado"));


    }

    //Organiza la data de sql
    private function sqldata($evaluado_id){

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);
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

        //Lo convertimos a un arreglo manipulable ya que recibimos un objecto sdtClass
        $dataarray = json_decode(json_encode($competencias), true);

        $collection= collect($dataarray);

        //Agrupamos la coleccion por nombre de competencia
        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name'] => [$item['average'],$item['relation'],$item['nivelrequerido']]];
        });

        //Creamos un arreglo desde la coleccion para contruir el arreglo
        $adata=[];
        foreach ($grouped as $key => $value) {

            $sumaaverage=0;
            $evaluador=[];
            $nivelrequerido=0;

            foreach ($value as $item) {
                $evaluador[] = ['name'=>$item[1],'average'=>$item[0]];
                $sumaaverage += $item[0];
                $nivelrequerido=$item[2];
            }
            $adata[]=['competencia'=>$key,'eva360'=>$sumaaverage/$value->count(),'nivelRequerido'=>$nivelrequerido,'data'=>$evaluador];
        }
        $adatacollection= collect($adata);

        return $adatacollection;
    }

}
