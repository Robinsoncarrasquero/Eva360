<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataEvaluacionGlobal;
use app\CustomClass\DataObjetivo;
use app\CustomClass\DataObjetivoGlobal;
use app\CustomClass\DataObjetivoPersonal;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use app\CustomClass\DataResultadoNivel;
use app\CustomClass\DataResultadoTipo;
use app\CustomClass\EnviarEmail;
use App\Evaluador;
use App\Evaluacion;
use App\Evaluado;
use App\Helpers\Helper;
use App\Medida;
use App\Objetivo;
use App\Proyecto;
use App\Role;
use App\SubMeta;
use App\SubProyecto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ObjetivosController extends Controller
{
    //
    public function __construct()
    {
    //    Auth::logout();
    }
    /**
     * Muestra las evaluaciones del evaluador
     */
    public function index(Request $request)
    {


        $title="Lista de Evaluados por Objetivos";
        $user = Auth::user();


        // if ($userroles->name==$admin->name){
        //    return redirect()->route('lanzarobjetivo.index');
        // }

        $evaluadores = Evaluador::has('objetivos')->with(['objetivos'=>function($query){
        $query->latest();
       }])->whereUser_id($user->id)->orderBy('created_at','desc')->simplePaginate(25);

        return view('objetivos.index',compact('evaluadores','title'));

    }
    /**Autenticacion con Token*/
    public function token($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::all()->where('remember_token',$token)->first();

        if($evaluador==\null){
           abort(404);
           return redirect('login');
        }
        $user=Auth::loginUsingId($evaluador->user_id);

        if (!Auth::check()){
            return redirect('login');
        }


        //Evaluacion del evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status==Helper::estatus('Finalizada')){
           return \redirect()->route('objetivo.index');
        }

        return \redirect()->route('objetivo.metas',$evaluador->id);

    }

    /**
     * El controlador recibe el token del evaluador y muestra la lista de competencias relacionadas.
     */
    public function metas($evaluador_id)
    {
        $evaluador = Evaluador::find($evaluador_id);
        $evaluado = $evaluador->evaluado;
        // if($evaluador->user_id != Auth::user()->id){
        //     \abort(404);
        // }

        $objetivos = $evaluador->objetivos;
        return \view('objetivos.metas',\compact('objetivos','evaluador','evaluado'));

    }

    /**
     * Controlador para cargar las preguntas a la vista.
     */
    public function responder($competencia_id){


        $objetivo = Objetivo::find($competencia_id);

        $mediciones = Medida::all();

        return \view('objetivos.responder',\compact('objetivo','mediciones'));
    }

    /**
     * El controlador Guardar la evaluacion con los resultados directamente
     */
    public function store(Request $request,$evaluacion_id){

        $validate = $request->validate(
            [
                'montocumplido'=>'required|numeric',
                'montoasignado'=>'required|numeric',
                'medidacheck'=>'required',
                'submeta'=>'required',
                // 'cumplida'=>'required|numeric|between:0,100',
                // 'requerido'=>'required|numeric|between:0,100',
            ],
            [
                'montocumplido.required'=>'Cantidad de la Meta Cumplida es requerida. Debe indicar un valor numerico',
                'montoasignado.required'=>'Cantidad de la Meta Asignada es requerida. Debe indicar un valor numerico',
                'medidacheck.required'=>'La Unidad de Medida es requerida. Debe seleccionar una unidad de medida'
            ]);


        $evaluacion=Objetivo::findOrFail($evaluacion_id);

        //Obtenemos el modelo de grado
        $modelsubmeta = $evaluacion->meta->submetas->first();

        //Obtenemos el modelo de las mediciones
        $modelMedida = Medida::find($request->medidacheck)->first;

        //Actualizamos el medida de la evaluacion
        $evaluacion->medida_id=$modelMedida->medida->id;

        //Actualizamos la submeta o pregunta de la evaluacion
        $evaluacion->submeta=$modelsubmeta->submeta;


        //Actualizamos el valor de la montocumplido y asignados
        $evaluacion->montoasignado=$request->montoasignado;
        $evaluacion->montocumplido=$request->montocumplido;

        //Actualizamos el porcentaje de valor requerido por el supervisor
        $evaluacion->requerido= 100;

        //Actualizamos el valor de la meta cumplida
        $evaluacion->cumplida=$request->montocumplido / $request->montoasignado * 100;

        //Obtenemos el resultado
        $evaluacion->resultado=  $request->montocumplido / $request->montoasignado * 100;

        $evaluacion->save();

        //redirigimos al usuario a ruta de sus competencias con el token del evaluador
        $evaluador=$evaluacion->evaluador;

        //Preguntas de la prueba
        $preguntas=$evaluador->evaluaciones->count();

        //Coleccion de preguntas
        $respuestas=$evaluador->objetivos;

        $respondidas=0;
        //Contamos las preguntas que faltan
        foreach ($respuestas as $key => $respuesta) {

            if ($respuesta->submeta){
                $respondidas ++;
            }
        }
        $falta= $preguntas - $respondidas;
        $mensaje=[0=>'Terminastes buen trabajo',1=>'Excelente, solo quedan '.$falta,2=>'Magnifico, ya llevas '.$respondidas, 3=>'Muy Bien, te restan '.$falta,3=>'Iniciastes muy bien, te restan '.$falta];

       // Alert::success($evaluacion->competencia->name,Arr::get($mensaje,$falta));

        return \redirect()->route('objetivo.metas',$evaluacion->evaluador->id);


    }

    /**
     * Controlador para indicar finalizaada la prueba del evaluador
     */
    public function finalizar(Request $request,$evaluador_id ){

        $evaluador = Evaluador::findOrFail($evaluador_id);
        $evaluaciones = $evaluador->objetivos;

        //Excluimos las competencias ya evaluadas
        $competencias = $evaluaciones->reject(function ($eva) {
            return $eva->resultado==0;
        })
        ->map(function ($eva) {
            return $eva->submeta;
        });

        //Revisamos cuantas estan pendientes por realizar
        if ($evaluaciones->count()>$competencias->count()){
           // Alert::error('Prueba inconclusa',Arr::random(['Culmínela','Finalícela','Terminála']));
            return \redirect()->back()->withDanger('Aun tiene competencias pendientes...');
        }

        $evaluado= $evaluador->evaluado;

        //Flag para indicar que le evaluador ha culminado la prueba
        $evaluador->status=Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
        $evaluador->save();


        //Excluimos a los evaluadores que han finzalizados
        $listaDeEvaluadores= $evaluado->evaluadores;
        $evaluacionesPendientes = $listaDeEvaluadores->reject(function ($eva) {
            return $eva->status==Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
        })
        ->map(function ($eva) {
            return $eva->status;
        });

        //Cambia el status del evaluador finalizada(2) la evaluacion
        if ($evaluacionesPendientes->count()==0){
            //Flag para indicar que le evaluado ha culminado la prueba
            $evaluado->status=Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
            $evaluado->save();

           //Enviamos el correo de finalizacion al administrador
            EnviarEmail::enviarEmailFinal($evaluado->id);
        }

        //Alert::success('Prueba Finalizada',Arr::random(['Good','Excelente','Magnifico','Listo','Bien hecho']));

        return \redirect()->route('manager.personal')
        ->withSuccess("Evaluacion de $evaluado->name finalizada exitosamente");

    }

     /**
     * Muestra los evaluadores con los objetivos para evaluar
     */
    public function evaluacion($evaluado)
    {
        $title="Resultados";

        $evaluado = Evaluado::find($evaluado);
       //Obtenemos los evaluadores del evaluador
        $evaluadores = $evaluado->evaluadores;

       return \view('objetivos.evaluacion',compact("evaluado","evaluadores","title"));


    }



     /*
     * Presenta los resultados finales numericos y ponderados de los objetivos evaluados
     */
    public function resultado($evaluado_id)
    {
        $title="Finales";

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $objDataEvaluacion = new DataObjetivo($evaluado_id);
        $competencias = $objDataEvaluacion->getDataEvaluacion();

        return \view('objetivos.resultados.final',compact("evaluado","competencias","title"));

    }

    /*
    * Presenta el resultado final en un grafico de linea
    */
    public function charindividual($evaluado_id)
    {
        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $loteEvaluados[]=$evaluado_id;
        $objData = new DataObjetivoPersonal($loteEvaluados,new DataObjetivo(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $title="Finales";
        // dd($dataSerie,$dataCategoria);
        if (!$dataSerie){
            \abort(404);
        }
        return \view('objetivos.resultados.charteva360',compact("dataSerie","dataCategoria","title","evaluado"));
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
        $objData = new DataObjetivoPersonal($loteEvaluados,new DataObjetivo(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();
        //dd($dataSerie,$dataBrecha,$dataCategoria);
        if (!$dataCategoria){
            \abort(404);
        }

        $title="Resultado personal por grupo";
        return \view('objetivos.resultados.subproyectos.charpersonalporgrupo',compact("dataSerie","dataCategoria","title","subProyecto",'dataBrecha'));
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
        $objData = new DataObjetivoPersonal($loteEvaluados,new DataObjetivo(0));
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
        return \view('objetivos.resultados.subproyectos.charpotencialporgrupo',compact("dataSerie","dataCategoria","title","subProyecto",'dataBrecha',"dataSerieBrecha","dataCategoriaBrecha"));
    }

    /**
     * Presenta grafica de columnas resultados generales por tipo de competencias agrupada por proyecto
     */
    public function resultadosGeneralesTipo($proyecto_id)
    {
        $subProyecto = Proyecto::find($proyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto

        //instanciamos un objeto de data por tipo
        $objData = new DataResultadoTipo($proyecto_id,new DataObjetivoGlobal(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataDofa = $objData->getDataFortalezaOptunidad();

        if (!$dataDofa){
            \abort(404);
        }
        $title="Resultados Generales por Tipo de Competencias ";
        return \view('objetivos.resultados.subproyectos.chartresultadosgenerales_tipo',compact("dataSerie","dataCategoria","dataDofa","title","subProyecto"));
    }

     /**
     * Presenta grafica lineal de competencias por niveles de cargos filtrada por proyecto
     */
    public function resultadosGeneralesNivel($proyecto_id)
    {
        $subProyecto = Proyecto::find($proyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto

        //instanciamos un objeto de data por tipo
        $objData = new DataResultadoNivel ($proyecto_id,new DataObjetivoGlobal(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataDofa = $objData->getDataFortalezaOptunidad();
        //dd($dataSerie,$dataCategoria);
        if (!$dataDofa){
            \abort(404);
        }
        $title="Resultados Generales por Nivel de Cargo";
        return \view('objetivos.resultados.subproyectos.chartresultadosgenerales_nivel',compact("dataSerie","dataCategoria","dataDofa","title","subProyecto"));
    }

}
