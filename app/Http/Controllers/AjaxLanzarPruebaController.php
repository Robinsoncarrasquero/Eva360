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

class AjaxLanzarPruebaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequest()
    {
        return view('ajaxRequest');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestPost(Request $request)
    {
        $input = $request->all();
       // \Log::info($input);
        // $user = Evaluador::find(1);
        // $user->seleccion= $id;



        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    //Lista de personas para la evaluacion
    public function index(Request $request)
    {
        //

        $title="Ajax Lista de Evaluados";
        $buscarWordKey = $request->get('buscarWordKey');

        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);

        // $evaluados = Evaluado::where('name','like',"%$buscarWordKey%")
        // ->orderBy('id','DESC')->paginate(5);

        //$evaluados=Evaluado::orderBy('id','DESC')->paginate(3);
        return view('lanzamiento.ajaxindex',compact('evaluados','title'));

    }

    //Selecciona las competencias a ser evaluadas
    public function seleccionar(Evaluado $evaluado)
    {
        $title="Ajax Lanzamiento de Prueba";

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Obtenemos las competencias
        $competencias = Competencia::paginate(5);

       return \view('lanzamiento.ajaxseleccionar',compact("evaluado","evaluadores","competencias","title"));

    }

    public function filtrar(Request $request)
    {
        # code...


        return response()->json(['success'=>'Got Simple Ajax Request.']);


    }

}
