<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataEvaluacionGlobal;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use app\CustomClass\DataResultadoNivel;
use app\CustomClass\DataResultadoTipo;
use Illuminate\Http\Request;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Proyecto;
use App\SubProyecto;
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

        $objDataEvaluacion = new DataEvaluacion($evaluado_id);
        $competencias = $objDataEvaluacion->getDataEvaluacion();

        return \view('resultados.finales',compact("evaluado","competencias","title"));

    }

    /*
    * Presenta la grafica final
    */
    public function charindividual($evaluado_id)
    {
        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //instanciamos un objeto de data resultados
        $objData = new DataResultado($evaluado_id,new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $title="Finales";
        if (!$dataSerie){
            \abort(404);
        }
        return \view('resultados.charteva360',compact("dataSerie","dataCategoria","title","evaluado"));
    }

    /**
     * Presenta la grafica de resultados personales por subproyecto
     */
    public function charpersonalporgrupo($subproyecto_id)
    {
        $subProyecto = SubProyecto::find($subproyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto
        $grupoevaluados = Evaluado::where('subproyecto_id',$subproyecto_id);
        $loteEvaluados=$grupoevaluados->pluck('id');

        //instanciamos un objeto de data personal
        $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();

        if (!$dataCategoria){
            \abort(404);
        }
        $title="Resultado personal por grupo";
        return \view('resultados.subproyecto.charpersonalporgrupo',compact("dataSerie","dataCategoria","title","subProyecto",'dataBrecha'));
    }

    /**
     * Presenta informacion tabuladada de analisis personal por subproyecto
     */
    public function analisiscumplimiento($subproyecto_id)
    {
        $subProyecto = SubProyecto::find($subproyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto
        $grupoevaluados = Evaluado::where('subproyecto_id',$subproyecto_id);
        $loteEvaluados=$grupoevaluados->pluck('id');

        //instanciamos un objeto de data personal
        $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();
        $dataSerieBrecha = $objData->getDataSerieBrecha();
        $dataCategoriaBrecha = $objData->getDataCategoriaBrecha();

        //dd($dataCategoriaBrecha,$dataSerieBrecha);
        if (!$dataBrecha){
            \abort(404);
        }
        $title="Analisis de cumplimiento";
        return \view('resultados.subproyecto.charpotencialporgrupo',compact("dataSerie","dataCategoria","title","subProyecto",'dataBrecha',"dataSerieBrecha","dataCategoriaBrecha"));
  //      return \view('resultados.subproyecto.cumplimiento',compact("dataSerieBrecha","dataCategoriaBrecha","title","subProyecto",'dataBrecha'));
    }

    /**
     * Presenta grafica de columnas resultados generales por tipo de competencias agrupada por proyecto
     */
    public function resultadosGeneralesTipo($proyecto_id)
    {
        $subProyecto = Proyecto::find($proyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto

        //instanciamos un objeto de data por tipo
        $objData = new DataResultadoTipo($proyecto_id,new DataEvaluacionGlobal(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataDofa = $objData->getDataFortalezaOptunidad();
        //dd($dataSerie);
        if (!$dataDofa){
            \abort(404);
        }
        $title="Resultados Generales por Tipo de Competencias ";
        return \view('resultados.subproyecto.chartresultadosgenerales_tipo',compact("dataSerie","dataCategoria","dataDofa","title","subProyecto"));
    }

     /**
     * Presenta grafica lineal de competencias por niveles de cargos filtrada por proyecto
     */
    public function resultadosGeneralesNivel($proyecto_id)
    {
        $subProyecto = Proyecto::find($proyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto

        //instanciamos un objeto de data por tipo
        $objData = new DataResultadoNivel ($proyecto_id,new DataEvaluacionGlobal(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataDofa = $objData->getDataFortalezaOptunidad();
        //dd($dataSerie,$dataCategoria);
        if (!$dataDofa){
            \abort(404);
        }
        $title="Resultados Generales por Nivel de Cargo";
        return \view('resultados.subproyecto.chartresultadosgenerales_nivel',compact("dataSerie","dataCategoria","dataDofa","title","subProyecto"));
    }


}
