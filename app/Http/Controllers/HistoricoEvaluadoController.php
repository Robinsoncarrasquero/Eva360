<?php

namespace App\Http\Controllers;

use App\Cargo;
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

class HistoricoEvaluadoController extends Controller
{
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
        return \view('historico.evaluado.historicoevaluadocreate',compact('empleado','evaluadores','cargos','proyectos','subproyectos','relations'));


    }

   /**Crea los datos del evaluado */
    public function storeevaluado(FileJson $fileJsonRequest)
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

}
