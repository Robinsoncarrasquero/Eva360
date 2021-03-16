<?php

namespace App\Http\Controllers;

use App\Cargo;
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
        $title="Lista de empleados por Departamentos";
        $user=Auth::user();
         //Ubicamos el rol
            $record = Departamento::findOrFail($user->departamento_id);
            $users = User::where('departamento_id', $record->id)->get();
            if ($user->id==$record->manager_id){
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
    /**Crear una evaluado con los datos de los evaluadores
     * de su entorno departamental
     */
    public function createevaluado($empleado_id)
    {

        $empleado=User::find($empleado_id);
        if (!$empleado){
            \abort(404);
        }
        /**
         * Representa los evaluadores del Empleado que estan en su departamento
         */
        $evaluadores= User::where('departamento_id',$empleado->departamento_id)->get();
        $evaluadores = $evaluadores->reject(function ($user) {
            return $user->active === false;
        });

        $cargos = Cargo::all();
        $proyectos = Proyecto::all();
        $subproyectos = SubProyecto::all();
        $relations = Relation::all();
        return \view('talent.crearevaluado',compact('empleado','evaluadores','cargos','proyectos','subproyectos','relations'));
    }

   /**Crea los datos del evaluado */
    public function storeevaluado(FileJson $fileJsonRequest,$empleado_id)
    {
        //

        $name=$fileJsonRequest->input('name.*');
        $relation=$fileJsonRequest->input('relation.*');
        $email=$fileJsonRequest->input('email.*');
        $prueba=$fileJsonRequest->input('evaluacion');
        $fileName='evaluado.json';
        $pathFile = 'config/'.$fileName;
        if (Storage::exists($pathFile)){
            $evaluado= new  Evaluado();
            $evaluado->name=$fileJsonRequest->nameevaluado;
            $evaluado->status=0;
            $evaluado->word_key= $prueba;
            $evaluado->cargo_id=$fileJsonRequest->cargo;
            $evaluado->subproyecto_id=$fileJsonRequest->subproyecto;
            $evaluado->user_id = $empleado_id;
            $evaluado->fb_status='No_Cumplida';
            $evaluado->save();

            for ($i=0; $i < count($name); $i++) {
                $evaluador= new Evaluador();
                $evaluador->name=$name[$i];
                $evaluador->email=$email[$i];
                $evaluador->relation= Str::of($relation[$i])->ucfirst();
                $evaluador->remember_token= Str::random(32);
                $evaluador->status=0;

                $evaluado->evaluadores()->save($evaluador);
            }

        }else{
            \abort(404);
        }

       // Alert::success('Evaluacion creada ..',Arr::random(['Good','Excelente','Magnifico','Exito']));

        return redirect()->route('proyectoevaluado.index')
        ->withSuccess('Evaluado creado con exito!!. Ya estamos listo para lanzar una evaluacion.');
    }


}
