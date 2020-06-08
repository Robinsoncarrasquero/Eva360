<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

use Illuminate\Http\Request ;
use App\Evaluado;
use App\Evaluador;
use App\Competencia;
use App\Evaluacion;
use Illuminate\Mail\Message;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Type\NullType;

use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluacionEnviada;

use App\Http\Requests\EvaluacionCreateRequest;

class LanzarPruebaController extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    //Lista de personas para la evaluacion
    public function index(Request $request)
    {
        $title="Lista de Evaluados";
        $buscarWordKey = $request->get('buscarWordKey');

        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);

        return view('lanzamiento.index',compact('evaluados','title'));

    }

    //Selecciona las competencias a ser evaluadas
    public function seleccionar(Evaluado $evaluado)
    {
        $title="Competencias";

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Obtenemos las competencias
        $competencias = Competencia::paginate(5);

       return \view('lanzamiento.seleccionar',compact("evaluado","evaluadores","competencias","title"));

    }

    //Filtra las competencias seleccionadas para confirmarlas
    public function confirmar(EvaluacionCreateRequest $request, $evaluado_id)
    {
        $competencias=$request->all('competenciascheck');

        $flattened = Arr::flatten($competencias);

        //Filtramos las competencias seleccionadas en el check
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Traemos al evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        $title='Confirmar Evaluacion';
        return \view('lanzamiento.confirmar',compact("evaluado","evaluadores","competencias","title"));

    }

    public function procesar(EvaluacionCreateRequest $formrequest,$evaluado_id){

        $formrequest->crearEvaluacion($evaluado_id);

        return \redirect()->route('lanzar.index')->with('success','Hurra!! Prueba lanzada exitosamente');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxupdate(Request $request, $id)
    {
        //
        dd($request);
        if ($request->ajax()){

            dd($request);

        }
    }


}
