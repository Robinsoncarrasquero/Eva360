<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Comportamiento;
use app\CustomClass\EnviarEmail;

use App\Frecuencia;
use App\Evaluador;
use App\Evaluacion;
use App\Grado;
use Illuminate\Http\Request;
use app\Helpers\Helper;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class EvaluacionController extends Controller
{

    public function __construct()
    {
    //    Auth::logout();
    }
    /**
     * Muestra las evaluaciones del evaluador
     */
    public function index(Request $request)
    {
        $title="Lista de Evaluados";
        $user = Auth::user();

        $evaluadores = Evaluador::has('evaluaciones')->with(['evaluaciones'=>function($query){
            $query->latest();
           }])->whereUser_id($user->id)->simplePaginate(25);

        return view('evaluacion.index',compact('evaluadores','title'));

    }
    /**Autenticacion con Token*/
    public function token($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::where('remember_token',$token)->first();
        if($evaluador==\null){
           abort(404);
           return redirect('login');
        }
        $user=Auth::loginUsingId($evaluador->user_id);

        if (!Auth::check()){
            return redirect('login');
        }
        session(['token' => $token]);

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
        $user =Auth::user();
        $userroles=$user->roles->first();
        //$roles = User::find($user)->roles()->orderBy('name')->get();

        $admin= Role::where('name','admin')->first();
        if ($evaluador->user_id != $user->id && !Auth::user()->is_manager && $userroles->name!==$admin->name){
            \abort(404);
        }

        // if(session()->has('token') &&  $evaluador->remember_token!=session('token')){
        //     \abort(404);
        // }

        $competencias = $evaluador->evaluaciones;
        return \view('evaluacion.competencias',\compact('competencias','evaluador','evaluado'));

    }

    /**
     * Controlador para cargar las preguntas a la vista.
     */
    public function responder($competencia_id){
        $user = Auth::user();
        $evaluacion=Evaluacion::find($competencia_id);

        $frecuencias =Frecuencia::all();

        return \view('evaluacion.comportamientos',\compact('evaluacion','frecuencias'));

    }

    /**
     * El controlador Guardar la evaluacion con los resultados directamente
     */
    public function store(Request $request,$evaluacion_id){

        $validate = $request->validate(
            [
                'gradocheck.*'=>'required',
                'frecuenciacheck.*'=>'required'
            ],
            [
                'gradocheck.*.required'=>'Debe seleccionar una opcion',
                'frecuenciacheck.*.required'=>'Debe indicar una frecuencia, este dato es requerido'
            ]);

        $gradocheck=$request->input('gradocheck.*');
        $frecuenciacheck=$request->input('frecuenciacheck.*');

        $evaluacion=Evaluacion::findOrFail($evaluacion_id);

        //seleccion multiple
        if ($evaluacion->competencia->seleccionmultiple){
            for ($i=0; $i < count($frecuenciacheck); $i++) {
                $datafrecuencia = explode(",", $frecuenciacheck[$i]);

                $frecuencia_id=$datafrecuencia[1];
                $valorfrecuencia=100;

                $frecuencia = Frecuencia::find($frecuencia_id);
                $valorfrecuencia=$frecuencia->valor;

                $comportamiento_id= $datafrecuencia[0];
                $conducta = Comportamiento::find($comportamiento_id);

                Comportamiento::updateOrCreate(['id'=>$comportamiento_id],
                [
                'ponderacion'=>$conducta->grado->ponderacion,
                'frecuencia'=>$valorfrecuencia,
                'resultado'=>$conducta->grado->ponderacion / 100 * $valorfrecuencia,
                ]);

            }
        }else{
            $valorfrecuencia=100;
            $conductas=Comportamiento::where('evaluacion_id',$evaluacion_id)->get();
            foreach ($conductas as $conducta) {
                $conducta->frecuencia=0;
                $conducta->ponderacion=0;
                $conducta->resultado=0;
                $conducta->save();
            }

            for ($i=0; $i < count($gradocheck); $i++) {
                $grado_id=$gradocheck[$i];
                $conducta = Comportamiento::find($grado_id);

                Comportamiento::updateOrCreate(['id'=>$grado_id],
                [
                'ponderacion'=>$conducta->grado->ponderacion,
                'frecuencia'=>$valorfrecuencia,
                'resultado'=>$conducta->grado->ponderacion,
                ]);
            }

        }

        $evaluacion->resultado= $evaluacion->competencia->seleccionmultiple ? $evaluacion->comportamientos->avg('resultado') : $evaluacion->comportamientos->sum('resultado') ;
        $evaluacion->save();
        //redirigimos al usuario a ruta de sus competencias con el token del evaluador
        $evaluador=$evaluacion->evaluador;

        //Preguntas de la prueba
        $preguntas=$evaluador->evaluaciones->count();

        //Coleccion de preguntas
        $respuestas=$evaluador->evaluaciones;

        $respondidas=0;
        //Contamos las preguntas que faltan
        foreach ($respuestas as $key => $value) {

            if ($value->resultado){
                $respondidas ++;
            }

        }

        $falta= $preguntas - $respondidas;

        $mensaje=[0=>'Terminastes buen trabajo',1=>'Excelente, solo quedan '.$falta,2=>'Magnifico, ya llevas '.$respondidas, 3=>'Muy Bien, te restan '.$falta,3=>'Iniciastes muy bien, te restan '.$falta];

       // Alert::success($evaluacion->competencia->name,Arr::get($mensaje,$falta));
        return \redirect()->route('evaluacion.competencias',$evaluacion->evaluador->id);

    }


     /**
     * El controlador Guardar la evaluacion con los resultados directamente
     */
    public function Xstore(Request $request,$evaluacion_id){

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
        $evaluacion->resultado=  $modelgrado->grado->ponderacion/100 * $modelfrecuencia->valor->valor ;

        $evaluacion->save();

        //redirigimos al usuario a ruta de sus competencias con el token del evaluador
        $evaluador=$evaluacion->evaluador;

        //Preguntas de la prueba
        $preguntas=$evaluador->evaluaciones->count();

        //Coleccion de preguntas
        $respuestas=$evaluador->evaluaciones;

        $respondidas=0;
        //Contamos las preguntas que faltan
        foreach ($respuestas as $key => $value) {

            if ($value->grado){
                $respondidas ++;
            }
        }
        $falta= $preguntas - $respondidas;
        $mensaje=[0=>'Terminastes buen trabajo',1=>'Excelente, solo quedan '.$falta,2=>'Magnifico, ya llevas '.$respondidas, 3=>'Muy Bien, te restan '.$falta,3=>'Iniciastes muy bien, te restan '.$falta];

       // Alert::success($evaluacion->competencia->name,Arr::get($mensaje,$falta));

        return \redirect()->route('evaluacion.competencias',$evaluacion->evaluador->id);
    }

    /**
     * Controlador para indicar finalizaada la prueba del evaluador
     */
    public function finalizar(Request $request,$evaluador_id ){

        $evaluador = Evaluador::findOrFail($evaluador_id);
        $evaluaciones = $evaluador->evaluaciones;

        //Excluimos las competencias ya evaluadas
        $competencias = $evaluaciones->reject(function ($eva) {
            return $eva->resultado==0;
        })
        ->map(function ($eva) {
            return $eva->resultado;
        });

        //Revisamos cuantas estan pendientes por realizar
        if ($evaluaciones->count()>$competencias->count()){
           // Alert::error('Prueba inconclusa',Arr::random(['Culmínela','Finalícela','Terminála']));
            return \redirect()->back()->withDanger('Aun tiene compentencias pendientes');
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

        return \redirect()->route('evaluacion.index')
        ->withSuccess("Evaluacion de $evaluado->name finalizada exitosamente");

    }


}
