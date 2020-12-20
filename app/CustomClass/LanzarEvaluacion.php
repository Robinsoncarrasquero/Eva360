<?php

namespace app\CustomClass;

use App\EmailSend;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Mail\EvaluacionEnviada;
use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LanzarEvaluacion
{
    private $competencias;
    private $evaluado_id;

    function __construct($competencias,$evaluado_id) {
        $this->competencias = $competencias;
        $this->evaluado_id = $evaluado_id;
    }

    /** Crea la evaluacion del evaluado */
    public function crearEvaluacion(){

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($this->evaluado_id);
        //Buscamos los evaluadores del evaluado
        $evaluadores = $evaluado->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($this->competencias as $key=>$this->competencia){
                $evaluacion = new Evaluacion();
                //$evaluacion->resultado=Helper::estatus('Inicio');
                $evaluacion->competencia_id=$this->competencia->id;
                try {
                    //Salvamos a la evaluacion
                    $eva360=$evaluador->evaluaciones()->save($evaluacion);

                    //Cambiamos status de Evaluado
                    $evaluadorx = Evaluador::find($evaluador->id);
                    $evaluadorx->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluadorx->save();

                } catch (QueryException $e) {
                    return false;
                }
            }

        }
        $evaluado->status=1; //0:Inicio, 1:Lanzada 2:finalizada
        $evaluado->save();

        return true;
    }

}
