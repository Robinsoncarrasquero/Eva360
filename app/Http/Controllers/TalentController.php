<?php

namespace App\Http\Controllers;

use App\Cargo;
use app\CustomClass\UserRelaciones;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\Http\Requests\FileJson;
use App\Proyecto;
use App\Relation;
use App\Role;
use App\SubProyecto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TalentController extends Controller
{

    //
    /**Lista los empleados */
    public function indexmanager(Request $request)
    {
        $title="Lista de empleados por Ubicacion";
        $user=Auth::user();

        //Ubicamos el rol
        $dpto = Departamento::findOrFail($user->departamento_id);
        if ($user->is_manager){
            $departamentos=Departamento::where('id',$user->departamento_id)->orderBy('id','DESC')->paginate(5);
        }else{
            $departamentos=Departamento::where('id',0)->orderBy('id','DESC')->paginate(5);
        }


        return \view('talent.index',compact('departamentos','title'));
    }


    //
    /**Lista los empleados */
    public function indexevaluado(Request $request)
    {
        $title="Lista de empleados por Departamentos";
        $buscarWordKey = $request->get('buscarWordKey');
        $departamentos = Departamento::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);
        return \view('talent.index',compact('departamentos','title'));
    }

    /**Lista el historico de evaluaciones del empleado */
    public function historicoevaluaciones($empleado_id)
    {

        $title="Historico de evaluaciones";
        $empleado = User::find($empleado_id);
        $evaluaciones = $empleado->evaluaciones;
        return \view('talent.historicoevaluaciones',compact('evaluaciones','title','empleado'));

        //return \redirect()->back()->withErrors('Falta programar este control');
    }

    /**
     * Crear una evaluado con los datos de los evaluadores
     * de su entorno departamental
     */
    public function createevaluado($empleado_id)
    {

        $empleado=User::find($empleado_id);
        if (!$empleado){
            \abort(404);
        }

        $userR= new UserRelaciones();
        $userR->Crear($empleado);

        $evaluadores = $userR->getEvaluadores();
        $metodos= $userR->getMetodos();

        $cargos = Cargo::all();
        $proyectos = Proyecto::where('tipo','<>','Objetivos')->get();

        $relations = Relation::all();

        return \view('talent.crearevaluado',compact('empleado','evaluadores','cargos','proyectos','relations','metodos'));
    }


    /**Crea los datos del evaluado */
    public function storeevaluado(Request $request,$empleado_id)
    {
        request()->validate(
            [
                'metodo' => 'required',
                'subproyecto' => 'required',
            ],
            [
                'metodo.required'=>'Debe seleccionar un metodo.',
                'subproyecto.required'=>'Debe seleccionar un Subproyecto.',
            ]
        );

        $user= User::find($empleado_id);
        $userR = new UserRelaciones();
        $userR->Crear($user);

        if (!$userR->CreaEvaluacion($request->metodo,$request->subproyecto,$request->autoevaluacion)){
            \abort(404);
        }

        // Alert::success('Evaluacion creada ..',Arr::random(['Good','Excelente','Magnifico','Exito']));

        return redirect()->route('proyectoevaluado.index')
        ->withSuccess('Evaluado creado con exito!!. Ya estamos listo para lanzar una evaluacion.');
    }


}
