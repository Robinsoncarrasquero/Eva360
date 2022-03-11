<?php

namespace app\CustomClass;

use App\Cargo;
use App\Competencia;
use App\Comportamiento;
use App\Configuracion;
use App\Departamento;
use App\EmailSend;
use App\Evaluacion;
use App\Evaluador;
use App\Evaluado;
use App\Frecuencia;
use App\Grado;
use App\Helpers\Helper;
use App\Mail\EvaluacionEnviada;
use App\Modelo;
use App\NivelCargo;
use App\Notifications\AutoEvaluacionFinalizada;
use App\Notifications\AutoEvaluacionFinalizadaPorRobot;
use App\Notifications\EvaluacionFinalizada;
use App\Notifications\EvaluacionFinalizadaSimulador;
use App\Notifications\EvaluacionPendiente;
use App\Notifications\RegistroAutoEvaluacionVirtual;
use App\Notifications\SimuladorEvaluacionFinalizada;
use App\Proyecto;
use App\SubProyecto;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Generator as Faker;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class Simulador
{
    private $user;
    private $configuracion;
    private $modelo;
    private $metodo;

    function __construct(User $user, $modelo, $metodo)
    {
        //Obtenemos la configuracion particular
        $this->user = $user;
        $this->modelo = $modelo;
        $this->metodo = $metodo;
        $this->configuracion = Configuracion::first();
    }


    public function CrearEvaluadores()
    {

        $user = $this->user;

        $metodo = $this->metodo;
        $modelo = Modelo::find($this->modelo);

        $date = Carbon::parse(now())->locale('us');
        $proyecto_name=$date->year.$date->getTranslatedShortMonthName('MMM YYYY');

        $proyecto = Proyecto::firstOrCreate(
            [
                'name' =>  'Virtual '.$proyecto_name,
            ],
            [
                'tipo' => 'Simulador',
                'description' => 'Virtual '.$proyecto_name ,
                'virtual' => true,
            ]
        );

        $subproyecto = subProyecto::firstOrCreate([
            'name' => $modelo->name,

        ], [
            'description' => $modelo->name,
            'proyecto_id' => $proyecto->id,
        ]);

        $nivelcargosupervisorio = NivelCargo::firstOrCreate(
            [
                'name' => 'Supervisorio Virtual',

            ],
            [
                'description' => 'Simulador Supervisorio Virtual',
                'virtual' => true,
            ]
        );

        $cargogerente = Cargo::firstOrCreate(
            [
                'name' => 'Gerente Virtual',

            ],
            [
                'description' => 'Simulador Gerente Virtual',
                'nivel_cargo_id' =>$nivelcargosupervisorio->id,
                'virtual' => true,
            ]
        );

        $nivelcargonosuper = NivelCargo::firstOrCreate(
            [
                'name' => 'No Supervisorio Virtual',

            ],
            [
                'description' => 'Simulador No Supervisorio Virtual',
                'virtual' => true,
            ]
        );

        $cargocliente = Cargo::firstOrCreate(
            [
                'name' => 'Cliente I/E Virtual',
            ],
            [
                'description' => 'Simulador Cliente I/E Virtual',
                'nivel_cargo_id' => $nivelcargonosuper->id,
                'virtual' => true,
            ]
        );

        $cargocolaboradores = Cargo::firstOrCreate(
            [
                'name' => 'Colaborador Virtual',
            ],
            [
                'description' => 'Simulador Colaborador Virtual',
                'nivel_cargo_id' => $nivelcargonosuper->id,
                'virtual' => true,
            ]
        );

        $departamento = Departamento::firstOrCreate(
            [
                'name' => 'Ventas Virtual',
            ],
            [
                'description' => 'Simulador Ventas Virtual',
                'virtual' => true,
            ]
        );

        $supervisor = User::updateOrCreate([
            'email' => 'supervisorvirtual@fb360.cf',
        ], [
            'cargo_id' => $cargogerente->id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Supervisor Virtual',
        ]);

        $par1 = User::firstOrCreate([
            'email' => 'parvirtual1@fb360.cf',
        ], [
            'cargo_id' => $user->cargo_id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Par Virtual',

        ]);

        $par2 = User::firstOrCreate([

            'email' => 'parvirtual2@fb360.cf',

        ], [
            'cargo_id' => $user->cargo_id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Par Virtual',

        ]);
        $pares[] = ['name' => $par1->name, 'email' => $par1->email, 'id' => $par1->id];
        $pares[] = ['name' => $par2->name, 'email' => $par2->email, 'id' => $par2->id];


        $colab1 = User::firstOrCreate([
            'email' => 'colaboradorvirtual1@fb360.cf',

        ], [
            'cargo_id' => $cargocolaboradores->id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Colaborador Virtual',

        ]);
        $colaboradores[] = ['name' => $colab1->name, 'email' => $colab1->email, 'id' => $colab1->id];

        $colab2 = User::firstOrCreate([

            'email' => 'colaboradorvirtual2@fb360.cf',

        ], [
            'cargo_id' => $cargocolaboradores->id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Colaborador Virtual',

        ]);
        $colaboradores[] = ['name' => $colab2->name, 'email' => $colab2->email, 'id' => $colab2->id];

        $cliente1 = User::firstOrCreate([

            'email' => 'clientevirtual1@fb360.cf',

        ], [
            'cargo_id' => $cargocliente->id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Cliente Virtual',

        ]);
        $clientes[] = ['name' => $cliente1->name, 'email' => $cliente1->email, 'id' => $cliente1->id];

        $cliente2 = User::firstOrCreate([

            'email' => 'clientevirtual2@fb360.cf',

        ], [
            'cargo_id' => $cargocliente->id,
            'departamento_id' => $departamento->id,
            'codigo' => ' ',
            'phone_number' => ' ',
            'password' => bcrypt('secret@1234'),
            'name' => 'Cliente Virtual',

        ]);
        $clientes[] = ['name' => $cliente2->name, 'email' => $cliente2->email, 'id' => $cliente2->id];

        $faker = Factory::create();

        //Metodo de 90 grados
        {
            //Creamos el evaluado
            $evaluado = new Evaluado();
            $evaluado->name = $user->name;
            $evaluado->status = 0;
            $evaluado->word_key = $metodo;
            $evaluado->cargo_id = $user->cargo_id;
            $evaluado->subproyecto_id = $subproyecto->id;
            $evaluado->user_id = $user->id;
            $evaluado->save();

            $esuper = new Evaluador();
            $esuper->name = $faker->name;

            $esuper->email = $supervisor->email;
            $esuper->relation = $this->configuracion->supervisor;
            $esuper->remember_token = Str::random(32);
            $esuper->status = 0;
            $esuper->user_id = $supervisor->id;
            $esuper->virtual= true;
            $evaluado->evaluadores()->save($esuper);

            //AutoEvaluacion
            {
                $autoeva = new Evaluador();
                $autoeva->name = $faker->name;
                $autoeva->email = $user->email;
                $autoeva->relation = $this->configuracion->autoevaluacion;
                $autoeva->remember_token = Str::random(32);
                $autoeva->status = 0;
                $autoeva->user_id = $user->id;
                $autoeva->virtual= true;
                $evaluado->evaluadores()->save($autoeva);
            }
        }

        //Generamos los pares en 180
        if ($metodo == '180' || $metodo == '270') {
            foreach ($pares as $par) {
                $npar = new Evaluador();
                $npar->name = $faker->name;;
                $npar->email = $par['email'];
                $npar->relation = $this->configuracion->pares;
                $npar->remember_token = Str::random(32);
                $npar->status = 0;
                $npar->user_id = $par['id'];
                $npar->virtual= true;
                $evaluado->evaluadores()->save($npar);
            }
        }

        //Generamos los subordinados enn 270
        if ($metodo == '270' || $metodo == '360') {

            foreach ($colaboradores as $sub) {
                $nsub = new Evaluador();
                $nsub->name = $faker->name;;
                $nsub->email = $sub['email'];
                $nsub->relation = $this->configuracion->subordinados;
                $nsub->remember_token = Str::random(32);
                $nsub->status = 0;
                $nsub->user_id = $sub['id'];
                $nsub->virtual= true;
                $evaluado->evaluadores()->save($nsub);
            }
        }

        //Generamos los clientes internos en 360
        if ($metodo == '360') {

            foreach ($clientes as $sub) {
                $nsub = new Evaluador();
                $nsub->name = $faker->name;;
                $nsub->email = $sub['email'];
                $nsub->relation = 'Clientes';
                $nsub->remember_token = Str::random(32);
                $nsub->status = 0;
                $nsub->user_id = $sub['id'];
                $nsub->virtual= true;
                $evaluado->evaluadores()->save($nsub);
            }
        }
        //Retorna el autoevaluado
        return $autoeva;
    }


    /**Procesa un evaluador virtual */
    public static function respuestaVirtual(Evaluado $evaluado,$autoevaluacion)
    {

        $evaluadores = $evaluado->evaluadores;

        Simulador::respuestaEvaluadores($evaluadores,$autoevaluacion);


    }

    /**Responde la prueba por cada evaluador */
    public static function respuestaEvaluadores($evaluadores,$autoevaluacion)

    {
        //Excluye la autoevaluacion cuando el evaluador responde la prueba.
        //Ena caso de pasar un ciclo sin responde el robot respondera la prueba automaticamente
        // y autoevaluacion indica true
        foreach ($evaluadores as $evaluador) {

            if ($autoevaluacion || (!$autoevaluacion && $evaluador->relation!='Autoevaluacion')){
                $evaluaciones = $evaluador->evaluaciones;
                foreach ($evaluaciones as $evaluacion) {
                    Simulador::add_comportamientos($evaluacion);
                }
                $evaluador->status=Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
                $evaluador->save();
                //Ennvia el correo de prueba finalida cuando se ha indicado que la fuerce a terminar
                if($autoevaluacion && $evaluador->relation=='Autoevaluacion'){
                    Simulador::emailevaluacionFinalizadaPorRobot($evaluador);
                }
            }
        }

    }

    //Respondera la prueba olvidada por el usuario despues de pasar un ciertoo tiempo
    //y enviarle los resultados
    public static function responderPruebaOlvidada($evaluadores)
    {
        $unsoloevaluadorporevaluado=$evaluadores->unique('evaluado_id');

        foreach ($unsoloevaluadorporevaluado as $evaluador) {
            //El robot enviara correo de finalizacion
            $evaluado=$evaluador->evaluado;
            $evaluado->status=Helper::estatus('Finalizada'); //0=Inicio,1=Lanzada, 2=Finalizada
            $evaluado->save();
            if (Simulador::tiempoMaximoParaResponder($evaluado->created_at)>10){
                simulador::respuestaVirtual($evaluado,true);
            }

        }

    }

    /** Generamos los comportamientos de cada competencia */
    public static function add_comportamientos(Evaluacion $evaluacion)
    {

        $competencia = Competencia::find($evaluacion->competencia_id);

        $grados = Grado::where('competencia_id',$competencia->id)->get();

        $conducta = Comportamiento::where('evaluacion_id', $evaluacion->id)->get();
        foreach ($conducta as $conducta) {
            $conducta->frecuencia = 0;
            $conducta->ponderacion = 0;
            $conducta->resultado = 0;
            $conducta->save();
        }
        $modelkeys=$grados->modelKeys();
        $gradokey=collect($modelkeys);
        $grado_id=$gradokey->random();

        foreach ($grados as $comportamiento) {
            $conducta = Simulador::conducta($comportamiento->ponderacion);
            $ponderacion = 0;
            $frecuencia = 0;
            $resultado = 0;
            if ($comportamiento->id == $grado_id  || $competencia->seleccionmultiple) {
                $ponderacion = Arr::get($conducta, 'ponderacion');
                $frecuencia = Arr::get($conducta, 'frecuencia');
                $resultado = Arr::get($conducta, 'resultado');
            }
            Comportamiento::updateOrCreate(
                [
                    'grado_id' => $comportamiento->id,
                    'evaluacion_id'=>$evaluacion->id,
                ],
                [
                    'poderacion' => $ponderacion,
                    'frecuencia' => $frecuencia,
                    'resultado' => $resultado,
                ]
            );


        }

        $evaluacion->resultado = $competencia->seleccionmultiple ? $evaluacion->comportamientos->avg('resultado') : $evaluacion->comportamientos->sum('resultado');

        $evaluacion->save();
    }

    /** Obtenemos los resultados de la condu$conducta en una array */
    public static function conducta($ponderacion)
    {

        $grado = Arr::random(['A', 'B', 'C', 'D']);
       // $gradofinal = Arr::get(['A' => 100, 'B' => 75, 'C' => 50, 'D' => 25], $findgrado);
        //$gradofinal=Arr::get(['A'=>$nivel*1,'B'=>$nivel*0.75,'C'=>$nivel*0.50,'D'=>$nivel*0.25],$grado);

        $xyz = Arr::random(['A', 'B', 'C', 'D']);
        //$frecuencia=Arr::get(['A'=>100,'B'=>75,'C'=>50,'D'=>25],$xyz);
        $frecuencia = Arr::random(['A' => 100, 'B' => 75, 'C' => 50, 'D' => 25]);

        $frecuencia = Arr::random(['A' => 100, 'B' => 100, 'C' => 100, 'D' => 75,'E' => 75, 'F' => 75, 'G' => 50, 'H' => 50,'I' => 25]);
        $resultado = round($ponderacion *  $frecuencia / 100, 2);
        return ['grado' => $grado, 'ponderacion' => $ponderacion, 'frecuencia' => $frecuencia, 'resultado' => $resultado];
    }

    /** Envia el correo de finalizacion de la prueba al administrador */
    public static function enviarEmailFinal($evaluado_id){

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $receivers = $evaluado->user->email;

        //Creamos un objeto para pasarlo a la clase Mailable
        $data = new EmailSend();
        $data->nameEvaluador="Administrador";
        $data->relation ="Admin";
        $data->email =$evaluado->user->email;;

        //$data->linkweb =$root."/resultados/$evaluado_id/finales";
        $data->linkweb =Route('resultados.charindividual',$evaluado_id);
        $data->nameEvaluado =$evaluado->name;
        $data->enviado =false;
        $data->save();
        try {
            Mail::to($receivers)->send(new EvaluacionEnviada($data,'mails.evaluacion-finalizada'));
            $data->enviado =true;
            $data->save();

        }catch(Throwable $e) {
            abort(404);
        }
        return true;

    }

    public static function emailRegistroAutoEvaluacion($evaluador)
    {
        $receptores = Evaluador::where('id',$evaluador->id)->get();
        $delay = now()->addSeconds(0);

        foreach ($receptores as $receptor) {
            $receptor->notify((new RegistroAutoEvaluacionVirtual('simulador.token'))->delay($delay));
        }
    }


    public static function emailevaluacionFinalizadaEvaluador(Evaluador $evaluador)
    {
        //Buscamos el Evaluado
        $user = $evaluador->user;
        //$receptores = Evaluador::where('evaluado_id',$evaluado->id)->get();

        $delay = now()->addSeconds(0);
        // foreach ($receptores as $receptor) {
        //     $receptor->notify((new SimuladorEvaluacionFinalizada($route)));
        // }
        $user->notify((new AutoEvaluacionFinalizada($evaluador))->delay($delay));

    }

    public static function emailevaluacionFinalizadaPorRobot(Evaluador $evaluador)
    {
        //Buscamos el Evaluado
        $user = $evaluador->user;
        //$receptores = Evaluador::where('evaluado_id',$evaluado->id)->get();

        $delay = now()->addSeconds(0);
        // foreach ($receptores as $receptor) {
        //     $receptor->notify((new SimuladorEvaluacionFinalizada($route)));
        // }
        $user->notify((new AutoEvaluacionFinalizadaPorRobot($evaluador))->delay($delay));

    }
    /**Nombre del proyecto virtual */
    public function nombre_proyecto_simulador(){

        $date = Carbon::parse(now())->locale('us');
        $proyecto_name=$date->year.$date->getTranslatedShortMonthName('MMM YYYY');
        return $proyecto_name;

    }

    public static function crear_cargo_dpto_virtual(){

        $nivelcargosupervisorio = NivelCargo::firstOrCreate(
            [
                'name' => 'Supervisorio Virtual',

            ],
            [
                'description' => 'Simulador Supervisorio Virtual',
                'virtual' => 1,
            ]
        );

        $cargogerente = Cargo::firstOrCreate(
            [
                'name' => 'Gerente Virtual',

            ],
            [
                'description' => 'Simulador Gerente Virtual',
                'nivel_cargo_id' =>$nivelcargosupervisorio->id,
                'virtual' => 1,
            ]
        );

        $nivelcargonosuper = NivelCargo::firstOrCreate(
            [
                'name' => 'No Supervisorio Virtual',

            ],
            [
                'description' => 'Simulador No Supervisorio Virtual',
                'virtual' => 1,
            ]
        );

        $cargocliente = Cargo::firstOrCreate(
            [
                'name' => 'Analista Virtual',
            ],
            [
                'description' => 'Simulador Analista Virtual',
                'nivel_cargo_id' => $nivelcargonosuper->id,
                'virtual' => 1,
            ]
        );

        $cargocolaboradores = Cargo::firstOrCreate(
            [
                'name' => 'Coordinador Virtual',
            ],
            [
                'description' => 'Simulador Coordinador Virtual',
                'nivel_cargo_id' => $nivelcargosupervisorio->id,
                'virtual' => 1,
            ]
        );

        $departamento = Departamento::firstOrCreate(
            [
                'name' => 'Ventas Virtual',
            ],
            [
                'description' => 'Simulador Ventas Virtual',
                'virtual' => true,
            ]
        );

    }



    //Calcula los minutos entre dos fechas
    public static function tiempoMaximoParaResponder($fecha)
    {
        //convertimos la fecha 1 a objeto Carbon
        $carbon1 = Carbon::now();
        //convertimos la fecha 2 a objeto Carbon
        $carbon2 = new Carbon ($fecha);
        //de esta manera sacamos la diferencia en minutos
        $minutesDiff=Carbon::now()->floatDiffInMinutes($fecha);
        return $minutesDiff;
    }



}
