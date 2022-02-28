<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataObjetivo;
use app\CustomClass\DataObjetivoPersonal;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataProyecto;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\FBstatu;
use App\FeedBack;
use App\Objetivo;
use App\Objetivo_Det;
use App\Periodo;
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

    $col_evaluados = Evaluado::whereSubproyecto_id($subproyecto->id)->orderBy('created_at','DESC')->get();

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
        $departamento_id=Auth::user()->departamento_id;

        $proyectos = Proyecto::has('subproyectos')->with(['subproyectos.evaluados.user' => function($query) use ($departamento_id) {
            $query->where('users.departamento_id', $departamento_id)->latest('created_at');
            }])->simplePaginate(25);

        return view('lanzarobjetivo.index',compact('proyectos'));

    }

    /** Consolida la informacion de los resultados de la evaluacion */
    public function consolidar($evaluado_id)
    {

        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);
        $proyecto_id = $evaluado->subproyecto->proyecto_id;

        /**Datos del evaluado competencias blandas */
        $evaluado_com = DataProyecto::consolidarEvaluadoCompetencias($evaluado->user_id,$proyecto_id);
        $loteEvaluadosCom[]=$evaluado_com->id;
        $competenciaData = new DataPersonal($loteEvaluadosCom,new DataEvaluacion(0));
        $competenciaData->procesarData();
        $dataSerieCom = $competenciaData->getDataSerie();
        $dataCategoriaCom = $competenciaData->getDataCategoria();
        $dataBrechaCom = $competenciaData->getDataBrecha();

        /**Datos del evaluado objetivo o competencias duras*/
        $evaluado_obj = DataProyecto::consolidarEvaluadoObjetivos($evaluado->user_id,$proyecto_id);
        $loteEvaluadosObj[]=$evaluado_obj->id;
        $objetivoData = new DataObjetivoPersonal($loteEvaluadosObj,new DataObjetivo(0));
        $objetivoData->procesarData();
        $dataSerieObj = $objetivoData->getDataSerie();
        $dataCategoriaObj = $objetivoData->getDataCategoria();
        $dataBrechaObj = $objetivoData->getDataBrecha();

        $evaluador = $evaluado_obj->evaluadores->unique('evaluador_id')->first();

        //Aqui busca un registro de una colleccion por ser los objetivos una meta con
        //varias submetas
        $objetivo = Objetivo::where('evaluador_id',$evaluador->id)->first();
        $objetivos = Objetivo::find($objetivo->id)->objetivos;
        $total =$dataBrechaObj[0]['cumplimiento'] + $dataBrechaCom[0]['cumplimiento'] ;
        $resultado=['data'=>['Resultado'=>$total/2,'Objetivos'=>$dataBrechaObj[0]['cumplimiento'],'Competencias'=>$dataBrechaCom[0]['cumplimiento']]];
        $resultado = collect($resultado);

        if (!$dataSerieCom || !$dataSerieObj){
            \abort(404);
        }

       return \view('manager.consolidar',compact("resultado","objetivos","dataSerieCom","dataCategoriaCom","dataBrechaCom","evaluado_com","dataSerieObj","dataCategoriaObj","dataBrechaObj"));


    }



}
