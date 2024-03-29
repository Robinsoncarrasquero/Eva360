<?php

namespace App\Http\Controllers;

use app\CustomClass\DataProyecto;
use app\CustomClass\EnviarEmail;
use app\CustomClass\EnviarSMS;
use app\CustomClass\LanzarObjetivo;
use app\CustomClass\UserRelaciones;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\Meta;
use App\Proyecto;
use App\SubProyecto;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class LanzarObjetivoController extends Controller
{
    //
    public function __construct(){


    }
     /**
     * Presenta la lista de las evaluados por objetivos
     *
     **/

    public function index(Request $request)
    {

        // if (!Auth::user()->is_manager && !Auth::admin()){
        //     return redirect('login');
        // }
        $buscarWordKey = $request->get('buscarWordKey');
        $proyectos= DataProyecto::getProyectosPorObjetivos($buscarWordKey);

        return view('lanzarobjetivo.index',compact('proyectos'));

    }
    /**
     * Selecciona las metas de la evaluacion por objetivos
     *
     **/
    public function seleccionar(Request $request, User $user)
    {
        $title="Metas";

        //Obtenemos las metas
        $metas = Meta::where('departamento_id',$user->departamento_id)->get();

        $buscarWordKey = " ";
        //$proyectos= DataProyecto::getProyectosPorObjetivos($buscarWordKey);
        $departamento_id = $user->departamento_id;
        $proyectos= DataProyecto::getSubproyectosPorObjetivosDpto($user->departamento_id);
        return view('lanzarobjetivo.seleccionar',compact("user","metas","title",'proyectos'));

    }


    /**
     * Genera las evaluacion por objetivos
     */
    public function procesar(Request $formrequest,User $user){

       $metas=$formrequest->validate(
            [
            'metascheck'=>'required'],

            ['metascheck.required' => 'Debe seleccionar al menos una meta. Es obligatorio'],

        );

        //Obtenemos el manager atraves del usuario logueado que efectivamente es el manager
        $user->departamento_id;
        $depto= Departamento::find($user->departamento_id);
        $usermanager= $depto->manager;

        //Generamos un array sigle
        $flattened = Arr::flatten($metas);

        // Filtramos las metas devueltas en el array con el metodo flatten
        // y creamos una coleccion de metas con el metodo only
        $datametas = Meta::all();
        $metas = $datametas->only($flattened);

        //creamos el evaluador
        $evaluado = new Evaluado();
        $evaluado->name = $user->name;
        $evaluado->cargo_id = $user->cargo_id;
        $evaluado->departamento_id = $user->departamento_id;
        $evaluado->user_id = $user->id;
        $evaluado->word_key = 'Objetivos';
        $evaluado->status =1;
        $evaluado->subproyecto_id = $formrequest->subproyecto;
        $evaluado->save();

        //creamos el evaluador que en este caso es el mismo evaluado
        $evaluador= new  Evaluador();
        $evaluador->name = $usermanager->name;
        $evaluador->relation ="Objetivos";
        $evaluador->remember_token = Str::random(32);
        $evaluador->status = 0;
        $evaluador->email = $usermanager->email;
        $evaluador->cargo_id = $usermanager->cargo_id;
        $evaluador->departamento_id = $usermanager->departamento_id;
        $evaluador->user_id = $usermanager->id;
        $evaluado->evaluadores()->save($evaluador);

        //Creamos un objeto para el lanzamiento de Evaluacion
        $Objetivo = new LanzarObjetivo($metas);

        if (!$Objetivo->crear($evaluado)){
            return \redirect()->route('lanzarobjetivo.index')
            ->with('error',"Error, Esas metas para el Evaluado $evaluado->name, ya habian sido lanzadas ..");
        }

        EnviarEmail::EmailNuevaEvaluacionPorObjetivo($evaluado->id);

        $Objetivo=null;
        if (Auth::user()->is_manager){
            return \redirect()->route('manager.personal')->with('success','La Evaluacion por objetivos de '.$evaluado->name.' ha sido lanzada exitosamente');
        }
        return \redirect()->route('lanzarobjetivo.index')->with('success','La Evaluacion por objetivos de '.$evaluado->name.' ha sido lanzada exitosamente');

    }
}
