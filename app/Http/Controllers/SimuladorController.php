<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Competencia;
use App\Comportamiento;
use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataObjetivo;
use app\CustomClass\DataObjetivoPersonal;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use app\CustomClass\EnviarEmail;
use app\CustomClass\LanzarEvaluacion;
use app\CustomClass\Simulador;
use App\Departamento;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Exports\FeedBackExport;
use App\FBstatu;
use App\FeedBack;
use App\Frecuencia;
use App\Helpers\Helper;
use App\Modelo;
use App\Periodo;
use App\Role;
use App\SubProyecto;
use App\User;
use Faker\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SimuladorController extends Controller
{


    /**Lista el historico de evaluaciones del empleado */
    public function historicoevaluaciones(Request $request)
    {

        $title = "Historico de evaluaciones";
        $empleado = Auth::user();

        $evaluaciones = $empleado->evaluaciones;
        return \view('simulador.historicoevaluaciones', compact('evaluaciones', 'title', 'empleado'));

        //return \redirect()->back()->withErrors('Falta programar este control');
    }


    //
    /**
     * Muestra las evaluaciones del evaluador
     */
    public function index(Request $request)
    {
        $title = "Lista de Evaluados";
        $user = Auth::user();

        $evaluadores = Evaluador::has('evaluaciones')->with(['evaluaciones' => function ($query) {
            $query->latest();
        }])->whereUser_id($user->id)->orderBy('created_at', 'desc')->simplePaginate(25);

        //$evaluadores = Evaluador::where('user_id',$user->id)->orderBy('created_at','desc')->simplePaginate(25);

        return view('simulador.index', compact('evaluadores', 'title'));
    }
    public function autoevaluacion(Request $request)
    {

        Simulador::crear_cargo_dpto_virtual();
        $faker = Factory::create();
        $nombre = $faker->firstName. " ".$faker->lastName;
        $email = '';
        $cargos = Cargo::where('virtual',true)->get();
        $departamentos = Departamento::where('virtual',true)->get();

        $modelos = Modelo::all();
        if (Auth::check()) {
            $nombre = Auth::user()->name;
            $email = Auth::user()->email;
            $cargos = Cargo::where('id', Auth::user()->cargo_id)->get();
            $departamentos = Departamento::where('id', Auth::user()->departamento_id)->get();
        }

        $metodos = ['90', '180', '270', '360'];
        return view('simulador.autoevaluacion', compact('cargos', 'departamentos', 'modelos', 'metodos', 'nombre', 'email'));
    }

    public function registrar(Request $request)
    {

        $request->validate(
            [
                'modeloradio' => 'required',
                'name' => 'required',
                'email' => 'required|unique:users,email,1',
                'email' => 'email:rfc,dns',
                //'metodoradio' => 'required',
            ],

            [
                'modeloradio.required' => 'Debe seleccionar un modelo.',
                'name.required' => 'El Nombre es requerido.',
                'email.email' => "Debe indicar un correo.",
                'email.required' => "Email de usuario es unico y obligatorio.",
                //'metodoradio.required' => 'Debe seleccionar un metodo de evaluacion.',
            ],

        );


        $modelo = Arr::get($request->modeloradio, '0', 0);

        $metodo = Arr::get($request->btn, '0', 0);

        if (Auth::check()) {

            $user = Auth::user();

        } else {
            try {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->departamento_id = $request->departamento;
                $user->cargo_id = $request->cargo;
                $user->codigo = Str::random(10);;
                $user->email_super = 'supervisorvirtual@fb360.cf';
                $user->email_verified_at = now();
                $user->password = bcrypt('secret1234');
                $user->remember_token = Str::random(10);
                $user->phone_number = '999-999-999';
                $user->virtual = true;
                $user->save();

                //Agredamos el rol simulador
                $user_role = Role::where('name', 'simulador')->first();

                $user->roles()->attach($user_role);
            } catch (QueryException $e) {
                return redirect()->back()
                    ->withErrors('Error, correo ya está en uso por otro usuario. Ingrese otro correo.');
            }
        }

        //registro de evaluadores

        $userSimulador = new Simulador($user, $modelo, $metodo);
        $autoevaluado = $userSimulador->CrearEvaluadores();
        if (!$autoevaluado) {
            return \redirect()->back()->withErrors($user->name . ', no se pudo crear la evaluación simulada, intente nuevamente');
        }

        //Creamos un objeto de lanzamiento de Evaluacion
        $objlanzaEvaluacion = new LanzarEvaluacion($modelo, $autoevaluado->evaluado_id);

        if (!$objlanzaEvaluacion->CrearEvaluacionPorModelo()) {
            return \redirect()->back()
                ->withErrors("Error, Esas competencias para $autoevaluado->name, ya habian sido lanzadas anteriormente..");
        }

        $objlanzaEvaluacion = null;

        //Envia un correo al evaluador simulador

        Simulador::emailRegistroAutoEvaluacion($autoevaluado);

        //Responder durante el registro
        //$evaluado = $autoevaluado->evaluado;
        //Simulador::respuestaVirtual($evaluado,false);
        // Simulador::emailevaluacionFinalizadaEvaluador($autoevaluado);

        // if (!Auth::check()) {

        //     return \redirect()->route('login')
        //     ->withSuccess('Auto Evaluacion Generada exitosamente. Verifique su bandeja de correos para ingresar al sistema!');

        // }

        return \redirect()->route('simulador.token', $autoevaluado->remember_token)
            ->withSuccess('Auto Evaluacion Generada exitosamente. Ahora responda el cuestionario del modelo de competencias!');
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
        $data = $competencias->pluck('name');
        // dd(response()->json(['datajson'=>$data->toArray()]));

        return response()->json(['success' => 'Got Simple Ajax Request.', 'dataJson' => $data->toArray()]);
    }

    /**Autenticacion con Token*/
    public function token($token)
    {

        //Filtramos el evaluador segun el token recibido
        $evaluador = Evaluador::where('remember_token', $token)->first();

        if ($evaluador == \null) {
            abort(404);
            return redirect('login');
        }
        $user = Auth::loginUsingId($evaluador->user_id);

        if (!Auth::check()) {

            return redirect('login');
        }
        session(['token' => $token]);

        //Evaluacion del evaluado esta terminada es redirigido a la lista de usuarios
        if ($evaluador->status == Helper::estatus('Finalizada')) {
            return \redirect()->route('simulador.index');
        }

        return \redirect()->route('simulador.competencias', $evaluador->id);
    }

     /*Redirige al usuario cuando ha finalizado la prueba para llevarlo al historico desde el correo
     recibido Token*/
     public function tokenresultado($token)
     {

         //Filtramos el evaluador segun el token recibido
         $evaluador = Evaluador::where('remember_token', $token)->first();

         if ($evaluador == \null) {
             abort(404);
             return redirect('login');
         }
         $user = Auth::loginUsingId($evaluador->user_id);

         if (!Auth::check()) {
             return redirect('login');
         }
        return \redirect()->route('simulador.historicoevaluaciones');
     }

    /**
     * El controlador recibe el token del evaluador y muestra la lista de competencias relacionadas.
     * Tambien permite acceder al administrador pero en modo de consulta
     */
    public function competencias($evaluador_id)
    {
        $evaluador = Evaluador::find($evaluador_id);
        $evaluado = $evaluador->evaluado;
        $user = Auth::user();
        $admin = User::find($user->id)->hasRole('admin');
        if ($evaluador->user_id != $user->id && !$admin) {
            \abort(404);
        }

        $competencias = $evaluador->evaluaciones;
        return \view('simulador.competencias', \compact('competencias', 'evaluador', 'evaluado'));
    }

    public function responder($competencia_id)
    {
        $user = Auth::user();
        $evaluacion = Evaluacion::find($competencia_id);

        $frecuencias = Frecuencia::all();

        return \view('simulador.comportamientos', \compact('evaluacion', 'frecuencias'));
    }

    /**
     * El controlador Guardar la evaluacion con los resultados directamente
     */
    public function store(Request $request, $evaluacion_id)
    {

        $validate = $request->validate(
            [
                'gradocheck.*' => 'required',
                'frecuenciacheck.*' => 'required',
            ],
            [
                'gradocheck.*.required' => 'Debe seleccionar una opcion',
                'frecuenciacheck.*.required' => 'Debe indicar una frecuencia, este dato es requerido',
            ]
        );


        $evaluacion = Evaluacion::findOrFail($evaluacion_id);

        $user = Auth::user();
        if ($evaluacion->evaluador->user_id != $user->id) {
            return back()->withError('Error de informacion, intento de violacion ....!');
            \abort(404);
        }

        $frecuenciacheck = $request->input('frecuenciacheck.*');

        if ($evaluacion->competencia->seleccionmultiple && $evaluacion->comportamientos->count() > count(collect($frecuenciacheck))) {
            return back()->withError('Debe seleccionar cada opcion y con su frecuencia');
        } elseif ($evaluacion->comportamientos->count() > 0 && count(collect($frecuenciacheck)) < 1) {
            return back()->withError('Debe especificar una opcion con su frecuencia');
        }

        //Inicializamos las conductas de seleccion simple
        $conductas = Comportamiento::where('evaluacion_id', $evaluacion_id)->get();

        foreach ($conductas as $conducta) {
            $conducta->frecuencia = 0;
            $conducta->ponderacion = 0;
            $conducta->resultado = 0;
            $conducta->save();
        }



        //Actualizamos las conductas con la frecuencia
        for ($i = 0; $i < count($frecuenciacheck); $i++) {

            $datafrecuencia = explode(",", $frecuenciacheck[$i]);

            $frecuencia_id = $datafrecuencia[1];
            $frecuencia = Frecuencia::find($frecuencia_id);

            $comportamiento_id = $datafrecuencia[0];
            $conducta = Comportamiento::find($comportamiento_id);

            Comportamiento::updateOrCreate(
                ['id' => $comportamiento_id],
                [
                    'ponderacion' => $conducta->grado->ponderacion,
                    'frecuencia' => $frecuencia->valor,
                    'resultado' => $conducta->grado->ponderacion / 100 * $frecuencia->valor,
                ]
            );
        }

        $evaluacion->resultado = $evaluacion->competencia->seleccionmultiple ? $evaluacion->comportamientos()->avg('resultado') : $evaluacion->comportamientos()->sum('resultado');
        $evaluacion->save();

        //redirigimos al usuario a ruta de sus competencias con el token del evaluador
        $evaluador = $evaluacion->evaluador;
        $evaluador->status = Helper::estatus('Inicio'); //0=Inicio,1=Lanzada, 2=Finalizada
        $evaluador->save();
        //Preguntas de la prueba
        $preguntas = $evaluador->evaluaciones->count();

        //Coleccion de preguntas
        $respuestas = $evaluador->evaluaciones;

        $respondidas = 0;
        //Contamos las preguntas que faltan
        foreach ($respuestas as $key => $value) {

            if ($value->resultado) {
                $respondidas++;
            }
        }

        $falta = $preguntas - $respondidas;

        $evaluado = $evaluador->evaluado;
        //El Robot responde la prueba completamente con todas las competencias
        //de los evaluadores virtuales
        Simulador::respuestaVirtual($evaluado,false);

        return \redirect()->route('simulador.competencias', $evaluacion->evaluador->id);
    }

    /**
     * Controlador para indicar finalizaada la prueba del evaluador
     */
    public function finalizar(Request $request, $evaluador_id)
    {

        $evaluador = Evaluador::findOrFail($evaluador_id);
        $evaluaciones = $evaluador->evaluaciones;

        //Excluimos las competencias ya evaluadas
        $competencias = $evaluaciones->reject(function ($eva) {
            return $eva->resultado == 0;
        })
            ->map(function ($eva) {
                return $eva->resultado;
            });

        $evaluado = $evaluador->evaluado;

        //Revisamos cuantas estan pendientes por realizar
        if ($evaluaciones->count() > $competencias->count()) {
            // Alert::error('Prueba inconclusa',Arr::random(['Culmínela','Finalícela','Terminála']));
            return \redirect()->back()->withDanger('Error aun tiene competencias pendientes por completar');
        }

        //Flag para indicar que le evaluador ha culminado la prueba
        $evaluador->status = Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
        $evaluador->save();


        //Excluimos a los evaluadores que han finzalizados
        $listaDeEvaluadores = $evaluado->evaluadores;
        $evaluacionesPendientes = $listaDeEvaluadores->reject(function ($eva) {
            return $eva->status == Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
        })
            ->map(function ($eva) {
                return $eva->status;
            });


        //Cambia el status del evaluador finalizada(2) la evaluacion
        if ($evaluacionesPendientes->count() == 0) {
            //Flag para indicar que le evaluado ha culminado la prueba
            $evaluado->status = Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
            $evaluado->save();

            //Enviamos el correo de finalizacion al administrador

            Simulador::emailevaluacionFinalizadaEvaluador($evaluador);
        }

        //Alert::success('Prueba Finalizada',Arr::random(['Good','Excelente','Magnifico','Listo','Bien hecho']));

        return \redirect()->route('simulador.index')
            ->withSuccess("Evaluacion de $evaluado->name finalizada exitosamente");
    }



    /*Presenta los resultados por evaluador sin ponderar*/
    public function resultados($evaluado_id)
    {
        $title = "Resultados";

        $evaluado = Evaluado::find($evaluado_id);
        //Obtenemos los evaluadores del evaluador
        $evaluadores = $evaluado->evaluadores;

        return \view('simulador.evaluacion', compact("evaluado", "evaluadores", "title"));
    }
    /*
     * Presenta los resultados finales numericos y ponderados
     */
    public function finales($evaluado_id)
    {
        $title = "Finales";
        $configuraciones =  app('configuracion')->data();

        //Obtenemos los evaluadores del evaluador
        $evaluado = Evaluado::find($evaluado_id);

        $objDataEvaluacion = new DataEvaluacion($evaluado_id);
        $competencias = $objDataEvaluacion->getDataEvaluacion();

        return \view('simulador.finales', compact("evaluado", "competencias", "title",'configuraciones'));
    }

    /*
    * Presenta la grafica final
    */
    public function charindividual($evaluado_id)
    {
        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);
        //En caso  que le evaluado no este logueado lo pasa solo pars resolver los resultados
        //temporal
        //Pendiente esto es no es lo ideal
        if (!Auth::check()) {
            $user = Auth::loginUsingId($evaluado->user_id);
        }
        //instanciamos un objeto de data resultados
        $objData = new DataResultado($evaluado_id, new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $title = "Finales";
        if (!$dataSerie) {
            \abort(404);
        }
        //dd($dataSerie,$dataCategoria);
        return \view('simulador.charteva360', compact("dataSerie", "dataCategoria", "title", "evaluado"));
    }

     /**
     * Presenta la grafica de resultados personales por subproyecto
     */
    public function charpersonalporgrupo($subproyecto_id)
    {
        $subProyecto = SubProyecto::find($subproyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto
        $grupoevaluados = Evaluado::where('subproyecto_id',$subproyecto_id);
        $loteEvaluados=$grupoevaluados->pluck('id');

        //instanciamos un objeto de data personal
        $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        $objData->procesarData();

        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();
        $dataBrechaPorCompetencias = $objData->getDataBrechaPorCompetencia();
        $dataCategoriaSinModelo = $objData->getDataCategoriaSinModelo();

        if (!$dataCategoria){
            \abort(404);
        }
        $title="Resultado personal por grupo";
        return \view('simulador.charpersonalporgrupo',compact("dataSerie","dataCategoria",
        "title","subProyecto",'dataBrecha','dataBrechaPorCompetencias','dataCategoriaSinModelo'));
    }

     /**
     * Presenta informacion tabuladada de analisis personal por subproyecto
     */
    public function analisiscumplimiento($subproyecto_id)
    {
        $subProyecto = SubProyecto::find($subproyecto_id);
        //Buscamos el grupo de evaluados relacionados al subproyecto
        $grupoevaluados = Evaluado::where('subproyecto_id',$subproyecto_id);
        $loteEvaluados=$grupoevaluados->pluck('id');

        //instanciamos un objeto de data personal
        $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();
        $dataSerieBrecha = $objData->getDataSerieBrecha();
        $dataCategoriaBrecha = $objData->getDataCategoriaBrecha();
        $dataBrechaPorCompetencias = $objData->getDataBrechaPorCompetencia();
        $dataCategoriaSinModelo = $objData->getDataCategoriaSinModelo();

        if (!$dataBrecha){
            \abort(404);
        }
        $title="Analisis de cumplimiento";
        return \view('simulador.charcumplimientoporgrupo',compact("dataSerie","dataCategoria",
        "title","subProyecto",'dataBrecha',"dataSerieBrecha","dataCategoriaBrecha",'dataBrechaPorCompetencias',
        'dataCategoriaSinModelo'));
    }



    /**
     * Simulador Feedback Update
     */
    public function feedbackupdate(Request $formrequest, $id)
    {
        $evaluado = Evaluado::find($id);
        if ($formrequest->input('fb_competencia.*')==null){

        }

        try {
            //Update a los feeedback
            $fb_competencia=$formrequest->input('fb_competencia.*');
            $fb_feedback=$formrequest->input('fb_feedback.*');
            $fb_finicio=$formrequest->input('fb_finicio.*');
            $fb_ffinal=$formrequest->input('fb_ffinal.*');
            //$fb_nota=$formrequest->input('fb_nota.*');
            $fb_status=$formrequest->input('fb_status.*');
            $fb_periodo=$formrequest->input('fb_periodo.*');
            $fb_development=$formrequest->input('fb_development.*');

            for ($i=0; $i < count($fb_competencia); $i++) {
                $fb= FeedBack::find($fb_competencia[$i]);
                $fb->feedback=$fb_feedback[$i];
                $fb->fb_finicio=$fb_finicio[$i];
                $fb->fb_ffinal=$fb_ffinal[$i];
                //$fb->fb_nota=$fb_nota[$i];
                $fb->periodo_id=$fb_periodo[$i];
                $fb->fbstatu_id=$fb_status[$i];
                $fb->development=$fb_development[$i];
                $fb->save();

            }

        } catch (QueryException $e) {
            Alert::error('Competencia '.$formrequest->competencia,Arr::random(['Duplicada','Registro Ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }

        if (Auth::user()->is_manager){

            return \redirect()->route('manager.staff',$evaluado->subproyecto_id)->withSuccess('FeedBack Actualizado con exito');
        }
        return \redirect()->route('simulador.historicoevaluaciones')->withSuccess('FeedBack Actualizado con exito');
    }

    /**
     * Exportar feedback en Excel de un evaluado.
     *
     */

   public function exportFeedBack(Evaluado $evaluado)
    {
        return Excel::download(new FeedBackExport($evaluado), 'FeedBackExport.xlsx');
    }

     /*
    * Edit Feedback de una evaluacion
    */
    public function feedbackedit($evaluado_id)
    {


        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $email = Auth::user()->email;
        $user= Auth::user();
        // if ($user->is_manager && $email!= $evaluado->user->email_super || $evaluado==null){
        //     abort(404);
        // }

        //instanciamos un objeto de data personal

        $loteEvaluados[]=$evaluado_id;
        if ($evaluado->word_key=="Objetivos"){
            $objData = new DataObjetivoPersonal($loteEvaluados,new DataObjetivo(0));
        }
        else {
            $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        }
        $objData->procesarDataConModelo();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();

        //Generamos las competencias del Feedback
        foreach ($dataSerie as $key=>$dataValue){

            $competencia=$dataValue['name'];
             //Modelo > resultado genera feedback
             //if ($dataValue['data'][0]>($dataValue['data'][1]))

             if ($dataValue['name']!=='Promedio' && ($dataValue['data'][0]>$dataValue['data'][1])){
                //dd($competencia);
                $feedbacks = FeedBack::firstOrCreate(
                    ['competencia'=> $competencia,
                    'evaluado_id' => $evaluado_id],
                    [
                //    'fb_status' => ($dataValue['data'][0]>($dataValue['data'][1]) ? 'No_Cumplida' : 'Cumplida')
                    ]
                );

             }

        }

        $fb_status=['Cumplida','No_Cumplida'];
        $fb_status= FBstatu::all();

        $feedbacks= $evaluado->feedback()->get();
        $periodos = Periodo::all();
        if (!$dataSerie){
            \abort(404);
        }

        switch ($evaluado->word_key) {
            case 'Objetivos':
                return \view('simulador.fbedit',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status','feedbacks','periodos'));
                break;

            default:
                return \view('simulador.fbedit',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status','feedbacks','periodos'));
            break;
        }

    }
}
