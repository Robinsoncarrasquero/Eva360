<?php

namespace App\Http\Controllers;

use App\Frecuencia;
use App\Evaluador;
use App\Evaluacion;
use App\Evaluado;
use Illuminate\Http\Request;
use app\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

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
        $evaluadores = $user->evaluaciones;
        return view('evaluacion.index',compact('evaluadores','title'));

    }
    /**Autenticacion con Token*/
    public function token($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::all()->where('remember_token',$token)->first();
        $evaluado = $evaluador->evaluado;
        $competencias = $evaluador->evaluaciones;
        $user=Auth::loginUsingId($evaluador->user_id,true);

        //Evaluacion ddel evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status==Helper::estatus('Finalizada')){
            return \redirect()->route('evaluacion.index');
        }

        return \view('evaluacion.competencias',\compact('competencias','evaluador','evaluado'));

    }


    /**
     * El controlador recibe el token del evaluador y muestra la lista de competencias relacionadas.
     */
    public function competencias($evaluador_id)
    {

        //Filtramos el evaluador segun el token recibido
        //$evaluador = Evaluador::all()->where('remember_token',$token)->first();
        $evaluador = Evaluador::find($evaluador_id);
        $evaluado = $evaluador->evaluado;
        $competencias = $evaluador->evaluaciones;
        //$user = $evaluador->user()->first();
        $user=Auth::loginUsingId($evaluador->user_id,true);


        // $credentials = $user->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     // Authentication passed...
        //     return redirect()->intended('dashboard');
        // }

        //Evaluacion ddel evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status==Helper::estatus('Finalizada')){
            $evaluado_id=$evaluado->id;

            $title="Lista de Evaluados";
            $evaluados = Evaluado::all();
            $evaluados = $evaluados->reject(function ($user) use ($evaluado_id) {
                return $user->id!==$evaluado_id;
            });
            $user = Auth::user();
            $evaluadores = $user->evaluaciones;
            return \redirect()->route('evaluacion.index');
            //return view('evaluacion.index',compact('evaluados','title',"evaluador"));
        }

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

        //Flag para indicar que le evaluador a culminado la prueba
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
