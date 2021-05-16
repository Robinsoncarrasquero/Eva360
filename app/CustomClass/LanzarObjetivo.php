<?php

namespace app\CustomClass;


use App\Objetivo;
use App\Evaluado;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LanzarObjetivo
{
    private $metas;

    function __construct($metas) {
        $this->metas = $metas;
    }

    /** Crea la evaluacion del evaluado */
    public function crear(Evaluado $evaluado){

        //Evaluadores del evaluado
        $evaluadores = $evaluado->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las metas
            foreach($this->metas as $key=>$this->meta){
                $evaluacion = new Objetivo();
                $evaluacion->meta_id = $this->meta->id;
                $evaluacion->requerido = $this->meta->nivelrequerido;
                $evaluacion->status ='No_Cumplida';
                try {
                    //Salvamos a la evaluacion
                    $evaluador->objetivos()->save($evaluacion);

                    //Cambiamos status de Evaluado
                    $evaluador->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluador->save();

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
