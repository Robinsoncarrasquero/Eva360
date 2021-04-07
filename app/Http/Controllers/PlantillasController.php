<?php

namespace App\Http\Controllers;

use App\CargaMasiva;
use App\Cargo;
use App\Competencia;
use app\CustomClass\EnviarEmail;
use app\CustomClass\EnviarSMS;
use app\CustomClass\LanzarEvaluacion;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\Imports\PlantillasImport;
use App\Imports\UsersImport;
use App\Modelo;
use App\NivelCargo;
use App\Plantilla;
use App\Proyecto;
use App\Relation;
use App\Role;
use App\SubProyecto;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

//use Maatwebsite\Excel\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Stringable;

class PlantillasController extends Controller
{

    // private $excel;

    // public function __construct(Excel $excel)
    // {
    //     $this->excel = $excel;
    // }


    public function fileupload()
    {

        return view('plantillas.fileupload');

    }

    /**
     * Sube el archivo tipo excel al servidor en la carpeta upload y luego redirecciona a una vista para validar
     * los datos recibidos en el archivo.
     */
    public function upload(Request $request)
    {

        request()->validate(
        [
            'fileName' => 'required|file|max:100',
            'fileName.*' => 'mimes:excel|max:100',
        ],
        [
            'fileName.required'=>'Debe seleccionar un archivo en formato Excel segun el formato definido.',
            //'fileName.max' => "El Maximo permitido para subir un archivo es un 1kb con un maximo de 1000 evaluadores."
        ]);

        $pathFile = $request->file('fileName')->store('uploads');


        //$data=$this->excel->import(new PlantillasImport, 'plantilla2.xlsx');


        $headings = (new HeadingRowImport)->toArray($pathFile);


        $data_excel_array = (new PlantillasImport)->toArray($pathFile);

        //Excel::import(new PlantillasImport, 'plantilla2.xlsx');

        $dt=Carbon::now();

        $metodo='90';
        $metodos=['90','180','360'];

        $carga_masiva_name='Carga_Masiva_'.$dt->toDayDateTimeString();


        $carga_masiva= CargaMasiva::firstOrCreate(['name'=>$carga_masiva_name],
        [
        'description'=>$carga_masiva_name,
        'metodo'=> $metodo,
        'file'=>$pathFile
        ]);

        Proyecto::firstOrCreate(['name'=>$carga_masiva_name],['description'=>$carga_masiva_name, 'carga_masivas_id'=> $carga_masiva->id]);

        foreach ($data_excel_array as $datarow)
        {

            foreach ($datarow as $key=> $row)

            {
                if ($row['ubicacion']!=\null){

                    Plantilla::firstOrCreate(['email' => $row['email'],'carga_masivas_id'=>$carga_masiva->id],[
                        'ubicacion' => $row['ubicacion'],
                        'name' => $row['name'],
                        'dni' => $row['dni'],
                        'email_super' => $row['email_super'],
                        'celular' => $row['celular'],
                        'manager' => $row['manager'],
                        'cargo' => $row['cargo'],
                        'nivel_cargo' => $row['nivel_cargo'],

                    ]);
                }
            }

        }
        //Obtenemos los modelo
        $modelos =  Modelo::all();
        return \view('plantillas.edit',compact('carga_masiva','metodos','modelos'));

    }



    public function procesar(Request $request,$id)
    {

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'metodo'=>'required',
            'modeloradio'=>'required',
            ],[
                'name.required'=>'Nombre es requerido',
                'description.required'=>'Descripcion es requerida',
                'modeloradio.required' => 'Debe seleccionar un modelo. Es mandatorio'
            ],

        );

        $modelo = Arr::get($request->modeloradio, '0', 0);

        try {

            $cm = CargaMasiva::findOrFail($id);
            $cm->name=$request->name;
            $cm->description= $request->description;
            $cm->metodo= $request->metodo;
            $cm->modelo_id= $modelo;
            $cm->save();

            $plantillas= $cm->plantillas;

            foreach ($plantillas as $plantilla) {

                # code...
                $ubicacion= Departamento::firstOrCreate(['name'=>$plantilla->ubicacion],
                    ['description'=>$plantilla->ubicacion,
                ]);

                $nivel_cargo= NivelCargo::firstOrCreate(['name'=>$plantilla->nivel_cargo],
                    ['description'=>$plantilla->nivel_cargo,
                ]);

                $cargo= Cargo::firstOrCreate(['name'=>$plantilla->cargo],
                    ['description'=>$plantilla->cargo,
                    'nivel_cargo_id'=>$nivel_cargo->id,
                ]);

                //Crea o actualizada usuario
                $user = User::firstOrCreate(['email'=>$plantilla->email],
                [
                'departamento_id'=>$ubicacion->id,
                'name'=>$plantilla->name,
                'codigo'=>$plantilla->dni,
                'cargo_id'=>$cargo->id,
                'phone_number'=>$plantilla->celular,
                'password'=>bcrypt('secret'),
                ]);
                // $role_user = Role::where('name', 'user')->first();
                // $user->roles()->attach($role_user);
                // $user->save();

                //Actulaizad manager
                if ($plantilla->manager){
                    $ubicacion->manager_id = $user->id;
                    $ubicacion->save();

                    //Eliminamos el rol anterior
                    //$user->roles($role_user)->detach();

                    //Asignamos el role de manager
                    // $role_manager = Role::where('name', 'manager')->first();
                    // $user->roles()->attach($role_manager);
                    // $user->save();
                }
            }


        } catch (QueryException $e) {

            return redirect()->back()
            ->withErrors('Error imposible Procesar esta Plantilla tiene errores. Revise que los datos este correctos en la hoja de Excel.');
        }



        return \redirect()->route('plantillas.index')->withSuccess('Importacion de Plantilla : '.$request->name.' Procesada exitosamente');
    }

    public function lanzar($id)
    {

        $carga_masiva = CargaMasiva::findOrFail($id);
        $modelos = Modelo::all();
        $metodos=['90','180','360'];
        return view('plantillas.lanzar',\compact('carga_masiva','metodos','modelos'));

    }
    public function crearevaluaciones(Request $request,$id)
    {


        $modelo = Arr::get($request->modeloradio, '0', 0);

        $cm = CargaMasiva::findOrFail($id);
        $cm->description= $request->description;
        $cm->metodo= $request->metodo;
        $cm->modelo_id= $modelo;
        $cm->save();

        $plantillas= $cm->plantillas;

        foreach ($plantillas as $plantilla) {

            //Usuario
            if (!$plantilla->manager){

                $user = User::where('email',$plantilla->email)->first();

                $supervisor= User::where('email',$plantilla->email_super)->first();
                $evaluadores[]=['name'=>$supervisor->name,'email'=>$supervisor->email,'user_id=>'=>$supervisor->id];


                $team = DB::table('plantillas')->where([
                    ['carga_masivas_id', '=', $plantilla->carga_masivas_id],
                    ['ubicacion', '=', $plantilla->ubicacion],
                ])->get();

                $subor=[];
                $pares=[];

                foreach ($team as $persona) {
                    # code...
                    $staff= User::where('email',$persona->email)->first();

                    //Subordinados quienes tiene el email_super con el email actual del registro
                    if ($persona->email_super==$plantilla->email ){
                        $subor[]=['name'=>$persona->name,'email'=>$persona->email,'user_id=>'=>$staff->id];
                    }
                    //Pares quienes tienen el mismos email_supervisor al registro actual
                    if ($persona->email_super==$plantilla->email_super && $persona->email!=$plantilla->email_super && $persona->email!=$plantilla->email){
                        $pares[]=['name'=>$persona->name,'email'=>$persona->email,'user_id=>'=>$staff->id];
                    }

                    //Cuando el supervisor reporta al correo del manager
                    if ($persona->email==$supervisor->email){
                        $manager= User::where('email',$persona->email_super)->first();
                        $evaluadores[]=['name'=>$manager->name,'email'=>$manager->email,'user_id=>'=>$manager->id];
                    }

                }

                //Sub proyecto
                $proyecto = Proyecto::where('carga_masivas_id',$cm->id)->first();

                $subproyecto = SubProyecto::firstOrCreate([
                    'name'=>$plantilla->ubicacion." ".$cm->id,
                    'proyecto_id'=>$proyecto->id,
                ],['description'=>$plantilla->ubicacion]);


                //Creamos el evaluado
                $evaluado= new Evaluado();
                $evaluado->name=$user->name;
                $evaluado->status=0;
                $evaluado->word_key= $cm->metodo;
                $evaluado->cargo_id=$user->cargo_id;
                $evaluado->subproyecto_id=$subproyecto->id;
                $evaluado->user_id=$user->id;
                $evaluado->save();

                //Metodo de 90 grados
                if(count($evaluadores)>1){

                    $manager_evaluador= new Evaluador();
                    $manager_evaluador->name=$manager->name;
                    $manager_evaluador->email=$manager->email;
                    $manager_evaluador->relation= ($cm->metodo=='90' ? 'Manager' :'Supervisor');
                    $manager_evaluador->remember_token= Str::random(32);
                    $manager_evaluador->status=0;
                    $manager_evaluador->user_id=$manager->id;
                    $evaluado->evaluadores()->save($manager_evaluador);

                    $supervisor_evaluador= new Evaluador();
                    $supervisor_evaluador->name=$supervisor->name;
                    $supervisor_evaluador->email=$supervisor->email;
                    $supervisor_evaluador->relation= ($cm->metodo=='90' ? 'Supervisor' :'Supervisor');
                    $supervisor_evaluador->remember_token= Str::random(32);
                    $supervisor_evaluador->status=0;
                    $supervisor_evaluador->user_id=$supervisor->id;
                    $evaluado->evaluadores()->save($supervisor_evaluador);
                }

                if($cm->metodo=='180' && count($evaluadores)>1 && count($pares)>1){
                    foreach ($pares as $key => $par) {
                        $par_evaluador= new Evaluador();
                        $par_evaluador->name=$par['name'];
                        $par_evaluador->email=$par['email'];
                        $par_evaluador->relation= 'Par';
                        $par_evaluador->remember_token= Str::random(32);
                        $par_evaluador->status=0;
                        $par_evaluador->user_id=$par['user_id'];
                        $evaluado->evaluadores()->save($par_evaluador);
                    }
                }

                if($cm->metodo=='360' && count($evaluadores)>1 && count($pares)>1 && count($subor)>1){
                    foreach ($subor as $key => $sub) {
                        $sub_evaluador= new Evaluador();
                        $sub_evaluador->name=$sub['name'];
                        $sub_evaluador->email=$sub['email'];
                        $sub_evaluador->relation= 'Subordinados';
                        $sub_evaluador->remember_token= Str::random(32);
                        $sub_evaluador->status=0;
                        $sub_evaluador->user_id=$sub['user_id'];
                        $evaluado->evaluadores()->save($sub_evaluador);
                    }
                }
                $cm->procesado= true;
                $cm->save();
            }
        }

        //Lanzar Modelo

        // Buscamos el modelo para obtener las competencias asociadas

        $modelo = Modelo::find($cm->modelo_id);

        //Obtenemos la coleccion de competencias asociadas al modelo
        $modelocompetencias = $modelo->competencias;

        //Obtenemos una coleccion de competencias
        $pluck = $modelocompetencias->pluck('competencia_id');

        //Convertimos la coleccion de competencias pluck en un array con flatten
        $flattened = Arr::flatten($pluck);

        $datacompetencias = Competencia::all();
        //Obtenemos una coleccion de competencias del array devuelto por flatten
        $competencias = $datacompetencias->only($flattened);

        //Sub proyecto
        $proyecto = Proyecto::where('carga_masivas_id',$cm->id)->first();

        foreach ($proyecto->subproyectos as $subproyecto) {

            foreach ($subproyecto->evaluados as $evaluado) {
                # code...

                $user = User::find($evaluado->user_id);

                //Creamos un objeto de lanzamiento de Evaluacion
                $objlanzaEvaluacion = new LanzarEvaluacion ($competencias,$evaluado->id);

                if (!$objlanzaEvaluacion->crearEvaluacion()){
                    return \redirect()->route('plantillas.verproyecto')
                    ->with('error',"Error, Esas competencias para el Evaluado $user->name, ya habian sido lanzadas en la Prueba..");
                }

                $objlanzaEvaluacion=null;
                if ($request->sendmail){
                    EnviarEmail::enviarEmailEvaluadores($evaluado->id);

                }
                if ($request->sendsms){
                     EnviarSMS::SendSMSFacade($evaluado->id);

                }

            }
        }

        return \redirect()->route('plantillas.verproyecto',$cm->id)->withSuccess('Importacion de Plantilla : '.$request->name.' Procesada exitosamente');
    }

    public function index()
    {

        $metodos=['90','180','360'];
        $carga_masiva= CargaMasiva::orderBy('created_at','DESC')->simplePaginate(25);
        return \view('plantillas.index',compact('carga_masiva','metodos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verproyecto($id)
    {
        $proyectos = Proyecto::where('carga_masivas_id',$id)->simplePaginate(10);

        return \view('plantillas.verproyecto',\compact('proyectos'));
    }



}
