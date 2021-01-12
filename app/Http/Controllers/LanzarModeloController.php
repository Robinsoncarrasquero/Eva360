<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request ;
use App\Evaluado;
use App\Competencia;
use app\CustomClass\EnviarEmail;
use app\CustomClass\EnviarSMS;
use app\CustomClass\LanzarEvaluacion;
use App\Modelo;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LanzarModeloController extends Controller
{

    /*
    * Seleccionar un modelo de evaluacion
    */
    public function seleccionarmodelo(Request $request,$evaluado){
        $title="Modelos";
        $evaluado = Evaluado::findOrFail($evaluado);

        //Palabra de busqueda
        $buscarWordKey = $request->get('buscarWordKey');
        //Obtenemos los modelo
        $modelos =  Modelo::name($buscarWordKey)->orderBy('id','DESC')->simplePaginate(25);

        return \view('lanzamiento.modelo.seleccionarmodelo',compact("modelos","evaluado","title"));
    }

    /**
     * Genera la evaluacion por modelo
     */
    public function procesarmodelo(Request $formrequest,$evaluado_id){

        $modelo=$formrequest->validate(
            [
            'modeloradio'=>'required'],

            ['modeloradio.required' => 'Debe seleccionar un modelo. Es requerido'],

        );

        //Creamos una array filtrando el modelo seleccionado en el formulario
        $modeloflattened = Arr::flatten($modelo);

        // Buscamos el modelo para obtener las competencias asociadas
        $modelo = Modelo::find($modeloflattened)->first();

        //Obtenemos la coleccion de competencias asociadas al modelo
        $modelocompetencias = $modelo->competencias;

        //Obtenemos una coleccion de competencias
        $pluck = $modelocompetencias->pluck('competencia_id');

        //Convertimos la coleccion de competencias pluck en un array con flatten
        $flattened = Arr::flatten($pluck);

        $datacompetencias = Competencia::all();
        //Obtenemos una coleccion de competencias del array devuelto por flatten
        $competencias = $datacompetencias->only($flattened);

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $user = User::find($evaluado->user_id);

        //Creamos un objeto de lanzamiento de Evaluacion
        $objlanzaEvaluacion = new LanzarEvaluacion ($competencias,$evaluado_id);

        if (!$objlanzaEvaluacion->crearEvaluacion()){
            return \redirect()->route('proyectoevaluado.index')
            ->with('error',"Error, Esas competencias para el Evaluado $evaluado->name, ya habian sido lanzadas en la Prueba..");
        }

        $objlanzaEvaluacion=null;

        EnviarEmail::enviarEmailEvaluadores($evaluado->id);
        // EnviarSMS::SendSMSFacade($evaluado_id);

        //Alert::success('Modelo fue lanzado',Arr::random(['Good','Excelente','Magnifico','Listo','Bien hecho']));

        return \redirect()->route('proyectoevaluado.index')->withSucess('success','Muy Bien, La Prueba de '.$evaluado->name.' ha sido lanzada exitosamente');

    }


}
