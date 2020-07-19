<?php

namespace App\Http\Controllers;

use App\Frecuencia;
use App\Evaluador;
use App\Evaluacion;
use App\Evaluado;
use App\User;
use Illuminate\Http\Request;
use app\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{

    public function __construct()
    {
    //Auth::logout();
    }
    /**
     * Muestra las evaluaciones del evaluador
     */
    public function index(Request $request)
    {
        $title="Lista de Evaluados";
        $user = Auth::user();
        //$evaluadores =  $user->evaluaciones;
        $evaluadores = Evaluador::where('user_id',$user->id)->orderBy('created_at','DESC')->simplePaginate(10);
        return view('evaluacion.index',compact('evaluadores','title'));

    }
    /**Autenticacion con Token*/
    public function token($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::all()->where('remember_token',$token)->first();
        $user=Auth::loginUsingId($evaluador->user_id);
        if (!Auth::check()){
            redirect('login');
        }

        //Evaluacion del evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status==Helper::estatus('Finalizada')){
           return \redirect()->route('evaluacion.index');
        }

        return \redirect()->route('evaluacion.competencias',$evaluador->id);

    }


    /**
     * El controlador recibe el token del evaluador y muestra la lista de competencias relacionadas.
     */
    public function competencias($evaluador_id)
    {
        $evaluador = Evaluador::find($evaluador_id);
        $evaluado = $evaluador->evaluado;
        $competencias = $evaluador->evaluaciones;
        return \view('evaluacion.competencias',\compact('competencias','evaluador','evaluado'));

    }

    /**
     * Controlador para cargar las preguntas a la vista.
     */
    public function responder($competencia_id){

        $evaluacion=Evaluacion::find($competencia_id);

        //Evaluadors
        $evaluador=$evaluacion->evaluador;

        //Competencia
        $competencia=$evaluacion->competencia;

        //Grado
        $grados=$competencia->grados;

        $frecuencias =Frecuencia::all();

        return \view('evaluacion.responder',\compact('evaluacion','frecuencias'));
    }

    /**
     * El controlador Guardar la evaluacion con los resultados directamente
     */
    public function store(Request $request,$evaluacion_id){

        $validate = $request->validate(
            [
                'gradocheck'=>'required',
                'frecuenciacheck'=>'required'
            ],
            [
                'gradocheck.required'=>'Debe seleccionar una opcion',
                'frecuenciacheck.required'=>'Debe indicar una frecuencia, este dato es requerido'
            ]);


        $evaluacion=Evaluacion::findOrFail($evaluacion_id);

        //Obtenemos el modelo de grado
        $modelgrado = $evaluacion->competencia->grados->find($request->gradocheck)->first;

        //Obtenemos el modelo la frecuencia
        $modelfrecuencia = Frecuencia::find($request->frecuenciacheck)->first;

        //Actualizamos el grado en la evaluacion
        $evaluacion->grado=$modelgrado->grado->grado;

        //Actualizamos la ponderacion
        $evaluacion->ponderacion= $modelgrado->grado->ponderacion;

        //Actualizamos la frecuencia
        $evaluacion->frecuencia=$modelfrecuencia->valor->valor;

        //Obtenemos el resultado
        $evaluacion->resultado=$modelfrecuencia->valor->valor * $modelgrado->grado->ponderacion/100;

        $evaluacion->save();

        //redirigimos al usuario a ruta de sus competencias con el token del evaluador
        $token=$evaluacion->evaluador->remember_token;
        return \redirect()->route('evaluacion.competencias',$evaluacion->evaluador->id);

    }

    /**
     * Controlador para indicar finalizaada la prueba del evaluador
     */
    public function finalizar($evaluador_id ){

        $evaluador = Evaluador::findOrFail($evaluador_id);
        $evaluaciones = $evaluador->evaluaciones;

        //Excluimos las competencias ya evaluadas
        $competencias = $evaluaciones->reject(function ($eva) {
            return $eva->frecuencia==0;
        })
        ->map(function ($eva) {
            return $eva->grado;
        });

        //Revisamos cuantas estan pendientes por realizar
        if ($evaluaciones->count()>$competencias->count()){
            return \redirect()->back()->withDanger('Aun tiene evaluaciones pendientes');
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
            $evaluado->status= Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
            $evaluado->save();
        }

        return \redirect()->route('evaluacion.index')
        ->withSuccess("Evaluacion de $evaluado->name finalizada exitosamente");

    }


}
