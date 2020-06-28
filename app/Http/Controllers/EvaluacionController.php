<?php

namespace App\Http\Controllers;

use App\Frecuencia;
use App\Evaluador;
use App\Evaluacion;
use App\Evaluado;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Foreach_;

class EvaluacionController extends Controller
{

    /**
     * Muestra las evaluaciones del evaluador
     */
    public function index(Request $request,$token)
    {
        $title="Lista de Evaluados";

        $evaluador = Evaluador::all()->where('remember_token',$token)->first();
        $evaluados = $evaluador->evaluado;
        $evaluado_id=$evaluador->evaluado_id;
        $buscarWordKey = $request->get('buscarWordKey');

        $evaluados = Evaluado::all();
        $evaluados = $evaluados->reject(function ($user) use ($evaluado_id) {
            return $user->id!==$evaluado_id;
        });

        return view('evaluacion.index',compact('evaluados','title',"evaluador"));

    }

    /**
     * El contolador recibe el token del evaluador y muestra la lista de competencias relacionadas.
     */


    public function competencias($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::all()->where('remember_token',$token)->first();
        $evaluado = $evaluador->evaluado;
        $evaluacions = $evaluador->evaluaciones;

        //Evaluacion ddel evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status==2){
            $evaluado_id=$evaluado->id;

            $title="Lista de Evaluados";
            $evaluados = Evaluado::all();
            $evaluados = $evaluados->reject(function ($user) use ($evaluado_id) {
                return $user->id!==$evaluado_id;
            });

            return view('evaluacion.index',compact('evaluados','title',"evaluador"));
        }

        return \view('evaluacion.competencias',\compact('evaluacions','evaluador','evaluado'));

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


        $evaluacion=Evaluacion::find($evaluacion_id);
        //Tomamos el grado

        $modelgrado = $evaluacion->competencia->grados->find($request->gradocheck)->first;

        $modelfrecuencia = Frecuencia::find($request->frecuenciacheck)->first;

        //Actualizamos el grado en la evaluacion
        $evaluacion->grado=$modelgrado->grado->grado;
        $evaluacion->ponderacion= $modelgrado->grado->ponderacion;
        //Actualizamos la frecuencia
        $evaluacion->frecuencia=$modelfrecuencia->valor->valor;
        $evaluacion->resultado=$modelfrecuencia->valor->valor * $modelgrado->grado->ponderacion/100;

        $evaluacion->save();

        //retomamos el token
        $token=$evaluacion->evaluador->remember_token;
        return \redirect()->route('evaluacion.competencias',$token);
    }

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

        //Flag para indicar que le evaluador a culimnado la prueba
        $evaluador->status=2; //0=Inicio,1=Lanzada, 2=Finalizada
        $evaluador->save();


        //Excluimos a los evaluadores que han finzalizados
        $listaDeEvaluadores= $evaluado->evaluadores;
        $evaluacionesPendientes = $listaDeEvaluadores->reject(function ($eva) {
            return $eva->status==2;
        })
        ->map(function ($eva) {
            return $eva->status;
        });

        //Sin evaluaciones pendientes de avanza a finalizar el status de finalizado. Este flag es para el administrador
        if ($evaluacionesPendientes->count()==0){
            $evaluado->status=2; //0=Inicio,1=Lanzada, 2=Finalizada
            $evaluado->save();
        }

        return \redirect()->route('evaluacion.index',$evaluador->remember_token)
        ->withSuccess("Evaluacion de $evaluado->name finalizada exitosamente");

    }



}
