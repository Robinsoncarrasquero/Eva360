<?php

namespace app\CustomClass;

use App\Evaluado;
use App\Proyecto;
use App\SubProyecto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DataProyecto
{
    private $metas;



    /** Crea la evaluacion del evaluado */
    public static function getProyectosTodos($buscarWordKey){

        $filtro=" ";

        $proyectos = Proyecto::name($buscarWordKey)->where('virtual','<>','1')->with(['subproyectos' => function($query) use ($filtro) {
            $query->where('subproyectos.tipo','<>',$filtro)->orderBy('created_at','DESC');
          }])->paginate(25);

        return $proyectos;
    }

     /** Crea la evaluacion del evaluado */
     public static function getProyectosPorCompetencias($buscarWordKey){

        $filtro = 'Competencias';
        $proyectos = DataProyecto::filtroProyecto($filtro,$buscarWordKey);

        return $proyectos;
    }

    public static function getProyectosPorObjetivos($buscarWordKey){
        $filtro = 'Objetivos';
        $proyectos = DataProyecto::filtroProyecto($filtro,$buscarWordKey);

        return $proyectos;
    }

    private static function filtroProyecto($filtro,$buscarWordKey)
    {

        $proyectos = Proyecto::name($buscarWordKey)->where('virtual','<>','1')->with(['subproyectos' => function($query) use ($filtro) {
            $query->where('subproyectos.tipo',$filtro)->orderBy('created_at','DESC');
          }])->paginate(25);

        return $proyectos;
    }


    public static function consolidarProyecto($evaluado_id,$proyecto_id)
    {
        $filtro=$evaluado_id;

        $proyectos = SubProyecto::where('proyecto_id',$proyecto_id)->with(['evaluados' => function($query) use ($filtro) {
            $query->where('evaluados.id',$filtro)->orderBy('created_at','DESC');
          }])->paginate(25);

        return $proyectos;
    }

    /**Nos devuelva las evaluaciones de una evaluador bajo de un proyecto */

    public static function consolidarEvaluado($user_id,$proyecto_id)
    {
        $filtro=$proyecto_id;

        $evaluados = Evaluado::where('user_id',$user_id)->with(['subproyecto' => function($query) use ($filtro) {
            $query->where('proyecto_id',$filtro)->orderBy('created_at','DESC');
          }])->paginate(25);

        return $evaluados;
    }

    public static function consolidarEvaluadoCompetencias($user_id,$proyecto_id)
    {
        $filtro=$proyecto_id;

        $evaluados = Evaluado::where('word_key','<>','Objetivos')->where('user_id',$user_id)->with(['subproyecto' => function($query) use ($filtro) {
            $query->where('proyecto_id',$filtro);
          }])->first();

        return $evaluados;
    }

    public static function consolidarEvaluadoObjetivos($user_id,$proyecto_id)
    {
        $filtro=$proyecto_id;

        $evaluados = Evaluado::where('word_key','Objetivos')->where('user_id',$user_id)->with(['subproyecto' => function($query) use ($filtro) {
            $query->where('proyecto_id',$filtro);
          }])->first();
        return $evaluados;
    }
}
