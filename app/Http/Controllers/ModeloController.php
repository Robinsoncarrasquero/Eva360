<?php

namespace App\Http\Controllers;

use App\Competencia;
use App\Modelo;
use App\ModeloCompetencia;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ModeloController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    //Lista los modelos
    public function index(Request $request)
    {
        $title="Modelos";
        $buscarWordKey = $request->get('buscarWordKey');

        $modelos = Modelo::name($buscarWordKey)->orderBy('id','DESC')->paginate(20);
        return view('modelo.index',compact('modelos','title'));

    }

    /*
    *Formulario para crear un modelo
    */
    public function create()
    {
        $title="Modelos";


        //Obtenemos las competencias
        $competencias = Competencia::all();

       return \view('modelo.create',compact("competencias","title"));

    }


    /**Crea el modelo  */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name'=>'required',
                'description'=>'required',
                'competenciascheck'=>'required',
            ],
            [
                'name.required'=>'Nombre del Modelo es Requerido',
                'description.required'=>'Descripcion del Modelo es requerido',
                'competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es obligatorio'
            ],

        );
        $competencias=$request->all('competenciascheck');

        //Generamos un array sigle
        $flattened = Arr::flatten($competencias);

        // Filtramos las competencias selecctionadas en el array generado por Array flatten
        // y creamos una coleccion nueva del modelo con el metodo collection only
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Creamos el Modelos
        $modelo = Modelo::firstOrCreate(
            ['name'=>$request->name],[
            'description' => $request->description,
        ]);

        //Creamos el modelo con sus respectivas competencias
        foreach($competencias as $key=>$competencia){
            try {
                $modeloCompetencia= new ModeloCompetencia();
                $modeloCompetencia->competencia_id=$competencia->id;
                $modelo->competencias()->save($modeloCompetencia);
            }catch(QueryException $e) {
                abort(404);
            }


        }

        return \redirect()->route('modelo.index')->withSuccess("Modelo Registrado exitosamente");

    }

    /*
    *Destruye un modelo
    */
    public function destroy($modelo){

        $modelo=Modelo::findOrFail($modelo);
        try {
            $modelo->delete();
        } catch (QueryException $e) {
             return \redirect()->back()
             ->withErrors('Error Imposible de Eliminar este Modelo, tiene algunas competencias asociadas');
        }

        return redirect('modelo')->withSuccess('El Modelo ha sido eliminado con exito!!');


    }

    /*
    *Muestra el modelo
    */
    public function show($modelo)
    {
        $title="Modelos";
        //Obtenemos el modelo
        $modelo = Modelo::findOrFail($modelo);
       return \view('modelo.show',compact("modelo","title"));

    }

    public function ajaxCompetencias(Request $request)
    {


        $id = $request->id;
        Log::info($id);
        $mcompetencias = Modelo::find($id)->competencias;
        $filtered = $mcompetencias->only(['competencia_id']);
        $plucked = $mcompetencias->pluck('competencia_id');

        $tablaCompetencias = Competencia::all();
        $competencias = $tablaCompetencias->only($plucked->toArray());
        $data=$competencias->pluck('name');
        return response()->json(['success'=>'Got Simple Ajax Request.','dataJson'=>$data->toArray()]);

    }





}
