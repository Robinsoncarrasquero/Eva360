<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

use Illuminate\Http\Request ;
use App\Evaluado;
use App\EmailSend;
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
use Illuminate\Database\QueryException;

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

        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(10);

        return view('lanzamiento.index',compact('evaluados','title'));

    }

    //Selecciona las competencias a ser evaluadas
    public function seleccionar(Evaluado $evaluado)
    {
        $title="Competencias";

        //Obtenemos los evaluadores del evaluador
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Obtenemos las competencias
        $competencias = Competencia::all();

       return \view('lanzamiento.seleccionar',compact("evaluado","evaluadores","competencias","title"));

    }

    //Filtra las competencias seleccionadas para confirmarlas
    public function confirmar(Request $request, $evaluado_id)
    {

        $request->validate(
            [
            'competenciascheck'=>'required'],

            ['competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es requerido'],

        );

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

    /**
     * Genera las evaluaciones lanzadas
     */
    public function procesarx(EvaluacionCreateRequest $formrequest,$evaluado_id){

        $formrequest->crearEvaluacion($evaluado_id);
        return \redirect()->route('lanzar.index')->with('success','Hurra!! Prueba lanzada exitosamente');

    }

    public function procesar(Request $formrequest,$evaluado_id){

        //$competencias= $formrequest->validated();
        $competencias=$formrequest->validate(
            [
            'competenciascheck'=>'required'],

            ['competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es requerido'],

        );

        $root=$formrequest->root();

        //Generamos un array sigle
        $flattened = Arr::flatten($competencias);

        // Filtramos las competencias devueltas en el array genrado por Array flatten
        // y creamos una coleccion nueva del modelo con el metodo collecction only
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Obeteremos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Obtenemos los evaluadores
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($competencias as $key=>$competencia){
                $evaluacion = new Evaluacion();
                $evaluacion->competencia_id=$competencia->id;
                try {
                    //Salvamos a la evaluacion
                    $eva360=$evaluador->evaluaciones()->save($evaluacion);

                    //Cambiamos status de Evaluado
                    $evaluadox=$evaluador->evaluado;
                    $evaluadox->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluadox->save();

                } catch (QueryException $e) {

                    return \redirect()->route('lanzar.index')
                    ->with('error',"Error, Esas competencias para el Evaluado $evaluado->name, ya habian sido lanzadas en la Prueba..");

                }
            }

        }


        // //Enviamos el correo a los evaluadores
        foreach($evaluadores as $evaluador){
            $receivers = $evaluador->email;

            //Creamos un objeto para pasarlo a la clase Mailable
            $data = new EmailSend();

            $data->nameEvaluador=$evaluador->name;
            $data->relation =$evaluador->relation;
            //$data->token=$evaluador->remember_token;
            $data->linkweb =$root."/evaluacion/$evaluador->remember_token/evaluacion";
            $data->nameEvaluado =$evaluado->name;
            Mail::to($receivers)->send(new EvaluacionEnviada($data));
        }

        return \redirect()->route('lanzar.index')->with('success','Hurra!! La Prueba de '.$evaluado->name.' ha sido lanzada exitosamente');


    }



}
