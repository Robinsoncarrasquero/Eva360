<?php

namespace app\CustomClass;

use App\Competencia;
use App\Comportamiento;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Modelo;
use App\Paypal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LanzarEvaluacion
{
    private $competencias;
    private $evaluado_id;
    private $modelo;

    function __construct($modelo,$evaluado_id) {
        $this->modelo = $modelo;
        $this->evaluado_id = $evaluado_id;
    }

    /** Genera el modelo por competencias **/
    public function modelo()
    {

        // Buscamos el modelo para obtener las competencias asociadas
        $modelo = Modelo::find($this->modelo)->first();

        //Obtenemos la coleccion de competencias asociadas al modelo
        $modelocompetencias = $modelo->competencias;

        //Obtenemos una coleccion de competencias
       // $pluck = $modelocompetencias->pluck('competencia_id');

        //Convertimos la coleccion de competencias pluck en un array con flatten
        //$flattened = Arr::flatten($pluck);

        //Obtenemos una coleccion de competencias del array devuelto por flatten
       // $datacompetencias = Competencia::all();
       // $competencias = $datacompetencias->only($flattened);

        return $modelocompetencias;
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
                $evaluacion->competencia_id=$this->competencia->id;
                try {
                    //Salvamos a la evaluacion
                    $evaluador->evaluaciones()->save($evaluacion);

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


    /** Crea la evaluacion del evaluado */
    public function crearEvaluacionMultiple(Evaluado $evaluado){

        //Buscamos los evaluadores del evaluado
        $evaluadores = $evaluado->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($this->competencias as $key=>$competencia){

                try {

                    //Creamos la evaluacion
                    $evaluacion=Evaluacion::firstOrCreate(['evaluador_id'=>$evaluador->id,'competencia_id'=>$competencia->id]);

                    //Add Comportamientos de la evaluacion
                    foreach ($competencia->grados as $grado) {
                        Comportamiento::firstOrCreate(['evaluacion_id'=>$evaluacion->id,'grado_id'=>$grado->id]);
                    }

                    $evaluador->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluador->save();

                } catch (QueryException $e) {
                    return false;
                }
            }

        }
        $evaluado->status=1; //0:Inicio, 1:Lanzada 2:finalizada
        $evaluado->save();

        $transaccion = new Transacciones();
        $transaccion->addTransaccion($evaluado->id);
        return true;
    }

    /** Crea la evaluacion por modelo dado */
    public function CrearEvaluacionPorModelo(){

        $modelocompetencias= $this->modelo();

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($this->evaluado_id);

        //Buscamos los evaluadores del evaluado
        $evaluadores = $evaluado->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($modelocompetencias as $key=>$competenciamodelo){

                try {

                    //Creamos la evaluacion
                    $evaluacion=Evaluacion::firstOrCreate([
                        'evaluador_id'=>$evaluador->id,
                        'competencia_id'=>$competenciamodelo->competencia_id],
                        [
                            'nivelrequerido'=>$competenciamodelo->nivelrequerido,
                    ]);

                    //Add Comportamientos de la evaluacion
                    foreach ($competenciamodelo->competencia->grados as $grado) {
                        Comportamiento::firstOrCreate(['evaluacion_id'=>$evaluacion->id,'grado_id'=>$grado->id]);
                    }

                    $evaluador->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluador->save();

                } catch (QueryException $e) {
                    dd($e);
                    return false;
                }
            }

        }
        $evaluado->status=1; //0:Inicio, 1:Lanzada 2:finalizada
        $evaluado->save();

        //Pagos diferidos
        $transaccion = new Transacciones();
        $transaccion->addTransaccion($evaluado->id);
        return true;
    }



}
