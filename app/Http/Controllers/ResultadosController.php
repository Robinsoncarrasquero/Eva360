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

        $competencias= collect($adatacollection);

        return \view('resultados.resumidos',compact("evaluado","competencias","title"));

    }
}
