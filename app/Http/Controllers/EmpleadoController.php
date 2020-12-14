<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\Http\Requests\FileJson;
use App\Proyecto;
use App\Relation;
use App\SubProyecto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmpleadoController extends Controller
{
    /**Lista los empleados */
    public function indexevaluado(Request $request)
    {
        $title="Lista de empleados por Departamentos";
        $buscarWordKey = $request->get('buscarWordKey');
        $departamentos = Departamento::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);
        return \view('empleado.index',compact('departamentos','title'));
    }

    /**Lista el historico de evaluaciones del empleado */
    public function historicoevaluaciones($empleado_id)
    {
        $title="Historico de evaluaciones";
        $empleado = User::find($empleado_id);
        $evaluaciones = $empleado->evaluaciones;
        //dd($evaluaciones);
        return \view('empleado.historicoevaluaciones',compact('evaluaciones','title','empleado'));

        return \redirect()->back()->withErrors('Falta programar este control');
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
        return \view('empleado.crearevaluado',compact('empleado','evaluadores','cargos','proyectos','subproyectos','relations'));
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

        return redirect()->route('proyectoevaluado.index')
        ->withSuccess('Evaluado creado con exito!!. Ya estamos listo para lanzar una evaluacion.');
    }

    public function destroy($empleado_id)
    {

        return redirect()->route('empleado.index')
        ->withSuccess('Evaluado creado con exito!!. Ya estamos listo para lanzar una evaluacion.');
    }
}
