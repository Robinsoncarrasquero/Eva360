<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Proyecto;
use App\Relation;
use App\SubProyecto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $relations = Relation::all();
        return \view('historico.evaluado.historicoevaluadocreate',compact('empleado','evaluadores','cargos','proyectos','relations'));


    }

    public function storeevaluado(Request $request, $id){

    }

}
