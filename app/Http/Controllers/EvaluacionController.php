<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Evaluador;
use App\Evaluacion;
use App\Evaluado;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    //
    public function responder($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::all()->where('remember_token',$token)->first();

        //Buscamos las evaluaciones del evaluador
        $evaluaciones= $evaluador->evaluaciones;

        //Bucamos el evaluado
        $evaluado = Evaluado::find($evaluador->evaluado_id);


        $listacompetencias=$evaluaciones->pluck('competencia_id');
        //Filtramos la competencias relacionadas con la evaluacion
        $competencias = Competencia::find($listacompetencias);


        return \view('evaluacion.index',\compact('competencias','evaluador','evaluado'));

    }


}
