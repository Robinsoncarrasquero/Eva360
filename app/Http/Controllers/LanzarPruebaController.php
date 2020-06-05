<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

use Illuminate\Http\Request;
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

class LanzarPruebaController extends Controller
{

    //Lista de personas para la evaluacion
    public function index(Request $request)
    {
        //

        $title="Lista de Evaluados";
        $buscarWordKey = $request->get('buscarWordKey');

        $evaluados = Evaluado::name($buscarWordKey)->orderBy('id','DESC')->paginate(5);

        // $evaluados = Evaluado::where('name','like',"%$buscarWordKey%")
        // ->orderBy('id','DESC')->paginate(5);

        //$evaluados=Evaluado::orderBy('id','DESC')->paginate(3);
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

    //Salvar la competencias seleccionadas y confirmarlas en otro view
    public function confirmar(Request $request, $evaluado_id)
    {
        //

        $competencias=$request->all('competenciascheck');

        if($competencias===[]){
            dd($competencias);
            return Redirect()->route('lanzar.index')->with('danger','Error, No ha seleccionado ninguna Competencias');
        }

        [$keys, $values] = Arr::divide($competencias);
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
    public function procesar(Request $request,$evaluado_id){

        $competencias=$request->all('competenciascheck');
        if($competencias===[]){
            return Redirect()->route('lanzar.index')->with('danger','Error, No ha seleccionado ninguna Competencias');
        }

        //Generamos un array sigle
        [$keys, $values] = Arr::divide($competencias);
        $flattened = Arr::flatten($competencias);

        // Filtramos las competencias devueltas en el array genrado por Array flatten
        // y creamos una coleccion nueva del modelo con el metodo colleccion only
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Obtenemos los evaluadores
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Recorremos los evaluadores
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($competencias as $key=>$value){
                $evaluacion = new Evaluacion();
                $evaluacion->competencia_id=$value->id;
                $evaluacion->ponderacion=0;
                $evaluacion->frecuencia=0;
                $evaluacion->evaluado_id=$evaluado->id;
                $unevaluador = Evaluador::find($evaluador->id);
                $eva360=$unevaluador->evaluacion()->save($evaluacion);
            }


        }

        foreach($evaluadores as $evaluador){

            $receivers = $evaluadores->pluck('email');

            $receivers= \collect(['rcarrasquero@gmail.com']);
            $to= 'rcarrasquero@gmail.com';

            $data = new Evaluador();
            $data->evaluadoName=$evaluador->name;
            $data->relation =$evaluador->relation;
            $data->token=$evaluador->remember_token;
            $data->siteweb ='http://eva360.test.ve/evaluacion/'.$evaluador->remember_token;
            $data->name =$evaluado->name;
            // Mail::to($receivers)->send(new EvaluacionEnviada($data));
            $data2=['evaluadorName'=>$evaluador->name,
            'relation'=>$evaluador->relation,
            'token'=>$evaluador->remember_token,
            'evaluadoName'=>$evaluado->name,
            'siteweb'=>$data->siteweb,

            ];

            Mail::send('evaluacionenviada', $data2, function ($msj) use ($to) {
                $msj->from("robinson.carrasquero@gmail.com", "Robinson Director");
                $msj->subject('Welcome');
                $msj->to($to);
            });



        }

        return \redirect()->route('lanzar.index')->with('success','Prueba lanzada exitosamente');

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
