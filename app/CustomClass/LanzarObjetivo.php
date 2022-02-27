<?php

namespace app\CustomClass;


use App\Objetivo;
use App\Evaluado;
use App\Objetivo_Det;
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
        $metas = $this->metas;
        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las metas
            foreach($metas as $key=>$meta){

                //Creamos la evaluacion
                $evaluacion=Objetivo::firstOrCreate(
                    [
                        'evaluador_id'=>$evaluador->id,
                        'meta_id'=>$meta->id,
                    ]);

                //Add Comportamientos de la evaluacion
                foreach ($meta->submetas as $submeta) {
                    Objetivo_Det::firstOrCreate([
                            'objetivo_id'=>$evaluacion->id,
                            'submeta_id'=>$submeta->id,
                        ],
                        [
                            'peso'=>$submeta->peso,
                            'valormeta'=>$submeta->valormeta,
                        ]);
                }

                try {

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
