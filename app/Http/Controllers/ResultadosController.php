<?php

namespace App\Http\Controllers;

use app\CustomClass\DataResultado;
use Illuminate\Http\Request;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ResultadosController extends Controller
{

    /*Presenta los resultados por evaluador sin ponderar*/
    public function resultados($evaluado_id)
    {
        $title="Resultados";

        $evaluado = Evaluado::find($evaluado_id);
       //Obtenemos los evaluadores del evaluador
        $evaluadores = $evaluado->evaluadores;

       return \view('resultados.evaluacion',compact("evaluado","evaluadores","title"));
    }
    /*
     * Presenta los resultados finales numericos y ponderados
     */
    public function resumidos($evaluado_id)
    {
        $title="Finales";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $objData = new DataResultado($evaluado_id);
        $competencias = $objData->dataCompetencias();

        return \view('resultados.finales',compact("evaluado","competencias","title"));

    }

    /*
    * Presenta la grafica final
    */
    public function graficas($evaluado_id)
    {
        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //instaciamos un objeto de data resultados
        $objData = new DataResultado($evaluado_id);
        $objData->crearGrafica();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $competencias = $objData->dataCompetencias();
        $title="Finales";
        return \view('resultados.charteva360',compact("dataSerie","dataCategoria","title","evaluado","competencias"));
    }

}
