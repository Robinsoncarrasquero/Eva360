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

    /*
    * Presenta los proyectos de evaluaciones del manager.
    *
    */
    public function index()
    {

        $manager = Auth::user();

        $departamento_id=$manager->departamento_id;

        $evaluados = DB::table('evaluados')
            ->whereExists(function ($query) use($departamento_id) {
               $query->select(DB::raw('1'))
                     ->from('users')
                     ->whereRaw("evaluados.user_id = users.id and users.departamento_id=$departamento_id");
            })->get();

        $unique=collect($evaluados)->pluck('subproyecto_id')->unique();
        $subproyectos= SubProyecto::WhereIn('id',$unique)->simplePaginate(25);

        // $subproyectos = SubProyecto::has('evaluados.user')->with(['evaluados.user' => function($query) use ($departamento_id) {
        // $query->where('users.departamento_id', $departamento_id)->latest('created_at');

        // }])->simplePaginate(25);

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

    // $subproyecto = SubProyecto::with(['evaluados.user' => function($query) use ($departamento_id) {
    //     $query->where('users.departamento_id', $departamento_id)->latest();
    // }])->findOrFail($subproyecto);

    $subproyecto = SubProyecto::findOrFail($subproyecto);

    $col_evaluados = Evaluado::whereSubproyecto_id($subproyecto->id)->get();

    $evaluados= $col_evaluados->filter(function($item) use($departamento_id)
    {
        if($item->user['departamento_id']==$departamento_id)
        {
            return $item;
        }
    });


    return \view('manager.staff',\compact('subproyecto','departamento_id','evaluados'));

   }


    /**Lista los empleados */
    public function personal(Request $request)
    {
        $user=Auth::user();
        $manager= $user->is_manager;

        if (!$manager){
            return redirect('login');
        }
        $title="Lista de empleados por Departamentos";
        // $buscarWordKey = $request->get('buscarWordKey');
        // $departamentos = Departamento::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);
        $departamento_id=Auth::user()->departamento_id;
        $departamentos=Departamento::where('id',$departamento_id)->orderBy('id','DESC')->paginate(25);

        return \view('manager.personal',compact('departamentos','title'));
    }

    /**Lista el historico de evaluaciones del empleado */
    public function historicoevaluaciones($empleado_id)
    {

        $title="Historico de evaluaciones";
        $empleado = User::find($empleado_id);
        $evaluaciones = $empleado->evaluaciones;
        return \view('manager.historicoevaluaciones',compact('evaluaciones','title','empleado'));

        //return \redirect()->back()->withErrors('Falta programar este control');
    }

    public function objetivosporproyecto(Request $request)
    {

        $buscarWordKey = $request->get('buscarWordKey');
        $proyectos = Proyecto::name($buscarWordKey)->where('tipo','Objetivos')->orderBy('id','DESC')->paginate(5);

        $departamento_id=Auth::user()->departamento_id;
        // $subproyectos = SubProyecto::has('evaluados')->with(['evaluados.evaluado' => function($query) use ($departamento_id) {
        // $query->where('departamento_id', $departamento_id)->latest('created_at');
        // }])->simplePaginate(25);
        $subproyectos = SubProyecto::has('evaluados')->with(['evaluados.user' => function($query) use ($departamento_id) {
            $query->where('departamento_id', $departamento_id)->latest('created_at');
            }])->simplePaginate(25);

        $proyectos = Proyecto::has('subproyectos')->with(['subproyectos.evaluados.user' => function($query) use ($departamento_id) {
            $query->where('users.departamento_id', $departamento_id)->latest('created_at');
            }])->simplePaginate(25);

        // dd($proyectos);
        // $subproyectos = SubProyecto::has('evaluados')->with(['evaluados'=>function($query){
        //     $query->latest();
        //    }])->whereDepartamento_id($manager->departamento_id)->simplePaginate(25);
        return view('lanzarobjetivo.index',compact('proyectos'));

    }



}
