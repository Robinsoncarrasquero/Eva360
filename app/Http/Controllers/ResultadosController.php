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
    //

    public function resultados($evaluado_id)
    {
        $title="Resultados";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);
        $evaluadores = $evaluado->evaluadores;

       return \view('resultados.resultadosevaluador',compact("evaluado","evaluadores","title"));

    }

    public function resumidos($evaluado_id)
    {
        $title="Finales";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);
        $evaluadores = $evaluado->evaluadores;

        $whereEvaluadores=$evaluadores->pluck('id');

        $competencias = DB::table('evaluaciones')
        ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
        ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
        ->select('competencias.name','evaluadores.relation',DB::raw('AVG(resultado) as calculo'))
        ->whereIn('evaluador_id',$whereEvaluadores)
        ->groupBy('competencias.name','relation')
        ->orderByRaw('competencias.name')
        ->get();
        $array = json_decode(json_encode($competencias), true);

        $collection= collect($array);

        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name'] => [$item['calculo'],$item['relation']]];
        });

        //dd($grouped);
        // $grouped->toArray();
        // dd($grouped);
        $competencias=collect($grouped);
        //dd($competencias);
        return \view('resultados.resumidos',compact("evaluado","competencias","title"));

    }
}
