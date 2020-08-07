<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request ;
use App\Evaluado;
use App\Competencia;
use app\ModelBussiness\LanzarEvaluacion;
use App\Modelo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LanzarPruebaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /*
     *Lista los candidatos para la evaluacion
     */
    public function index(Request $request)
    {
        $title="Lista de Evaluados";
        $buscarWordKey = $request->get('buscarWordKey');

        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(10);
        return view('lanzamiento.index',compact('evaluados','title'));

    }

    //Selecciona las competencias de la evaluacion
    public function seleccionar(Evaluado $evaluado)
    {
        $title="Competencias";

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::findOrFail($evaluado->id)->evaluadores;

        //Obtenemos las competencias
        $competencias = Competencia::all();

       return \view('lanzamiento.seleccionar',compact("evaluado","evaluadores","competencias","title"));

    }

    /**
     * Presenta las competencias seleccionadas para confirmarlas antes de procesar la evaluacion
    */
    public function confirmar(Request $request, $evaluado_id)
    {

        $request->validate(
            [
            'competenciascheck'=>'required'],

            ['competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es requerido'],

        );

        $competencias=$request->all('competenciascheck');

        //Creamos una array de las competencias seleccionadas en el formulario
        $flattened = Arr::flatten($competencias);

        //Obtenemos una coleccion de las competencias del array devuelto por flatten
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Buscamos al evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Obtenemos los evaluadores del evaluado
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        $title='Confirmar Evaluacion';
        return \view('lanzamiento.confirmar',compact("evaluado","evaluadores","competencias","title"));

    }

    /**
     * Genera las evaluacion por competencias
     */
    public function procesar(Request $formrequest,$evaluado_id){

       $competencias=$formrequest->validate(
            [
            'competenciascheck'=>'required'],

            ['competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es obligatorio'],

        );

        $root=$formrequest->root();

        //Generamos un array sigle
        $flattened = Arr::flatten($competencias);

        // Filtramos las competencias devueltas en el array con el metodo flatten
        // y creamos una coleccion de competencias con el metodo only
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Buscamos al evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Creamos un objeto para el lanzamiento de Evaluacion
        $objlanzaEvaluacion = new LanzarEvaluacion ($competencias,$evaluado_id,$root);

        if (!$objlanzaEvaluacion->crearEvaluacion()){
            return \redirect()->route('lanzar.index')
            ->with('error',"Error, Esas competencias para el Evaluado $evaluado->name, ya habian sido lanzadas en la Prueba..");
        }

        $objlanzaEvaluacion=null;

        return \redirect()->route('lanzar.index')->with('success','Hurra!! La Prueba de '.$evaluado->name.' ha sido lanzada exitosamente');

    }

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

        return \view('lanzamiento.seleccionarmodelo',compact("modelos","evaluado","title"));
    }

     /**
      * Presenta la lista de candidatos para lanzar un modelo
      */
     public function lanzarmodelo(Request $request)
     {
         $title="Lista de Evaluados";
         $buscarWordKey = $request->get('buscarWordKey');

         $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(10);
         return view('lanzamiento.modelo',compact('evaluados','title'));

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

            $root=$formrequest->root();

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

            //Creamos un objeto de lanzamiento de Evaluacion
            $objlanzaEvaluacion = new LanzarEvaluacion ($competencias,$evaluado_id,$root);
            if (!$objlanzaEvaluacion->crearEvaluacion()){
                return \redirect()->route('lanzar.modelo')
                ->with('error',"Error, Esas competencias para el Evaluado $evaluado->name, ya habian sido lanzadas en la Prueba..");
            }
            $objlanzaEvaluacion=null;
            return \redirect()->route('lanzar.modelo')->with('success','Hurra!! La Prueba de '.$evaluado->name.' ha sido lanzada exitosamente');

    }


}
