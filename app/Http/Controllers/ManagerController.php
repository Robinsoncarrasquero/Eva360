<?php

namespace App\Http\Controllers;

use App\Departamento;
use App\Evaluado;
use App\Proyecto;
use App\SubProyecto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    //
    public function __construct(){


    }

    public function index()
    {

        if (!Auth::user()->is_manager){
            return redirect('login');
        }

        $manager = Auth::user();

        $departamento_id=$manager->departamento_id;

        $subproyectos = SubProyecto::with(['evaluados.evaluado' => function($query) use ($departamento_id) {
        $query->where('departamento_id', $departamento_id);
        }])->get();

        return \view('manager.index',compact('subproyectos'));
    }

    /*
    * Presenta las evaluaciones del staff del manager.
    *
    */
   public function staff($subproyecto)
   {


    if (!Auth::user()->is_manager){
        return redirect('login');
    }

    $departamento_id=Auth::user()->departamento_id;

    $subproyecto = SubProyecto::with(['evaluados.evaluado' => function($query) use ($departamento_id) {
        $query->where('departamento_id', $departamento_id);
    }])->findOrFail($subproyecto);

    $subproyecto_id=$subproyecto->id;
    $col_evaluados = Evaluado::whereSubproyecto_id($subproyecto_id)->get();

    $evaluados= $col_evaluados->filter(function($item) use($departamento_id)
    {
        if($item->user['departamento_id']==$departamento_id)
        {
            return $item;
        }
    });

    return \view('manager.staff',\compact('subproyecto','departamento_id','evaluados'));

   }



}
