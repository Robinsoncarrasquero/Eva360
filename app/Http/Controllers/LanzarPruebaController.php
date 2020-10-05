<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request ;
use App\Evaluado;
use App\Competencia;
use app\CustomClass\LanzarEvaluacion;
use App\Modelo;
use App\Proyecto;
use App\SubProyecto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LanzarPruebaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Lista los candidatos para la evaluacion
     *
     **/

    public function index(Request $request)
    {
        $title="Lista de Evaluados Por Proyecto";
        $buscarWordKey = $request->get('buscarWordKey');
        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(10);
        return view('lanzamiento.index',compact('evaluados','title'));

    }

    /**
     * Selecciona las competencias de la evaluacion
     *
     **/
    public function seleccionar(Evaluado $evaluado)
    {
        $title="Competencias";

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::findOrFail($evaluado->id)->evaluadores;

        //Obtenemos las competencias
        $competencias = Competencia::all();

       return \view('lanzamiento.simple.seleccionar',compact("evaluado","evaluadores","competencias","title"));

    }

    /**
    * Presenta las competencias seleccionadas previamente para confirmarlas antes de generar la evaluacion
    *
    **/
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
        return \view('lanzamiento.simple.confirmar',compact("evaluado","evaluadores","competencias","title"));

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

}
