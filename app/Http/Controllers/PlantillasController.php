<?php

namespace App\Http\Controllers;

use App\CargaMasiva;
use App\Cargo;
use App\Competencia;
use app\CustomClass\EnviarEmail;
use app\CustomClass\EnviarSMS;
use app\CustomClass\LanzarEvaluacion;
use app\CustomClass\UserRelaciones;
use App\Departamento;
use App\Evaluado;
use App\Evaluador;
use App\Exceptions\Handler;
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

        $headings = (new HeadingRowImport)->toArray($pathFile);

        $data_excel_array = (new PlantillasImport)->toArray($pathFile);

        $carga_masiva= CargaMasiva::firstOrCreate(['name'=>$carga_masiva_name],
        [
        'description'=>$carga_masiva_name,
        'metodo'=> $metodo,
        'file'=>$pathFile
        ]);

        Proyecto::firstOrCreate(['name'=>$carga_masiva_name],
        [
            'description'=>$carga_masiva_name,
            'carga_masivas_id'=> $carga_masiva->id
        ]);

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
        $errores=[];


        $plantillas= Plantilla::where('carga_masivas_id',$carga_masiva->id)->get();

        foreach ($plantillas as $plantilla) {


            //Crea o actualizada usuario
            $user = User::where('email',$plantilla->email)->first();
            if($user!==null){

               if ($user->hasRole('admin') ){
                    $errores[] = $user;
                    $errores2[] = ['name'=>$plantilla->name,
                    'email'=>$plantilla->email,
                    'email_super'=>$plantilla->email_super,
                    'ubicacion'=>$plantilla->ubicacion,
                    'usuario'=>'admin',
                    'error'=>'El usuario admin es exclusivo y no tiene dependientes funcionales',
                ];
               }
            }

        }
        if ($errores)
        {
            $errores2= collect($errores2);
            $carga_masiva->delete();

            return \view('plantillas.errores',compact('errores','errores2','carga_masiva'));
        }


        $modelos =  Modelo::all();
        return \view('plantillas.edit',compact('carga_masiva','metodos','modelos','pathFile'));

    }


    /**
     * Procesa los datos de la plantilla importada
     */
    public function procesar(Request $request,$id)
    {

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            // 'metodo'=>'required',
            // 'modeloradio'=>'required',
            ],[
                'name.required'=>'Nombre es requerido',
                'description.required'=>'Descripcion es requerida',
                // 'modeloradio.required' => 'Debe seleccionar un modelo. Es mandatorio'
            ],

        );

        //Obtenemos el modelo
        $modelo = Arr::get($request->modeloradio, '0', 0);

        try {

            $cm = CargaMasiva::findOrFail($id);
            $cm->name=$request->name;
            $cm->description= $request->description;
            //$cm->metodo= $request->metodo;
            // $cm->modelo_id= $modelo;
            $cm->save();

            $plantillas= $cm->plantillas;

            foreach ($plantillas as $plantilla) {

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
                $user = User::updateOrCreate(['email'=>$plantilla->email],
                [
                'departamento_id'=>$ubicacion->id,
                'name'=>$plantilla->name,
                'codigo'=>$plantilla->dni,
                'cargo_id'=>$cargo->id,
                'phone_number'=>$plantilla->celular,
                'password'=>bcrypt('secret'),
                'email_super'=>$plantilla->email_super,
                ]);

                if(!$user->hasRole('user')){
                    $role_user = Role::where('name', 'user')->first();
                    $user->roles()->attach($role_user);
                    $user->save();
                }

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

        if ($request->updateplantilla){
            $record= CargaMasiva::find($cm->id);
            $record->delete();
            return \redirect()->route('talent.index')->withSuccess('Plantilla actualizada exitosamente ');
        }

        return \redirect()->route('plantillas.index')->withSuccess('Importacion de Plantilla : '.$request->name.' Procesada exitosamente');
    }

    /**
     * Lanza las evaluaciones de una plantilla importada
     */
    public function lanzar($id)
    {

        $carga_masiva = CargaMasiva::findOrFail($id);
        $modelos = Modelo::all();
        $metodos=['90','180','360'];
        return view('plantillas.lanzar',\compact('carga_masiva','metodos','modelos'));

    }

    /**
     * Genera la evaluaciones de la carga masiva
     */
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

            //Un empleado no manager
            if (!$plantilla->manager){

                //Sub proyecto
                $proyecto = Proyecto::where('carga_masivas_id',$cm->id)->first();

                $subproyecto = SubProyecto::firstOrCreate([
                    'name'=>$plantilla->ubicacion." ".$cm->id,
                    'proyecto_id'=>$proyecto->id,
                ],['description'=>$plantilla->ubicacion]);

                $user = User::where('email',$plantilla->email)->first();

                $userR= new UserRelaciones();
                $userR->Crear($user);

                if (!$userR->CreaEvaluacion($request->metodo,$subproyecto->id,$request->autoevaluacion)){
                    \abort(404);
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

                //Creamos un objeto para el lanzamiento de la Evaluacion
                $objlanzaEvaluacion = new LanzarEvaluacion ($competencias,$evaluado->id);
                if (!$objlanzaEvaluacion->crearEvaluacionMultiple($evaluado)){
                //if (!$objlanzaEvaluacion->crearEvaluacion()){
                    return \redirect()->route('plantillas.verproyecto')
                    ->with('error',"Error, Esas competencias para el Evaluado $user->name, ya habian sido lanzadas en la Prueba..");
                }

                $objlanzaEvaluacion=null;

                //Inyectamos dependencia para enviar email
                if ($request->sendmail){
                    EnviarEmail::enviarEmailEvaluadores($evaluado->id);
                }

                //Inyesctamos dependencia para enviar sms
                if ($request->sendsms){
                     EnviarSMS::SendSMSFacade($evaluado->id);
                }

            }
        }

        return \redirect()->route('plantillas.verproyecto',$cm->id)->withSuccess('Importacion de Plantilla : '.$request->name.' Procesada exitosamente');
    }

    /**
     * Muestra las plantillas de carga masivas importadas
     */
    public function index()
    {

        $metodos=['90','180','360'];
        $carga_masiva= CargaMasiva::orderBy('created_at','DESC')->simplePaginate(25);

        return \view('plantillas.index',compact('carga_masiva','metodos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($carga_masiva)
    {
        try {
            $record= CargaMasiva::find($carga_masiva);
            $record->delete();
            $success = true;
            $message = "Carga masiva eliminada exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar este registro, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene un modelo de competencias asociado');
        }
        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);


        // return  redirect()->route('plantillas.index')->withSuccess('Carga masiva eliminada con exito');
    }

    /**
     * Muestra las evaluaciones de carga masiva
     */
    public function verproyecto($id)
    {
        $proyectos = Proyecto::where('carga_masivas_id',$id)->simplePaginate(10);

        return \view('plantillas.evaluaciones',\compact('proyectos'));
    }

    /**
     * Muestra el organigrama dinamicamente
     */
    public function organigrama($plantilla)
    {
        return \view('plantillas.organigrama');
    }


}
