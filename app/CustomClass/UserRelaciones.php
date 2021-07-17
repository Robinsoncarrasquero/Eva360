<?php

namespace app\CustomClass;

use App\Configuracion;
use App\Evaluador;
use App\Evaluado;
use App\User;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class UserRelaciones
{
    private $user;
    private $subordinados;
    private $pares;
    private $manager;
    private $supervisor;
    private $team;
    private $configuracion;
    function __construct() {
        //Obtenemos la configuracion particular
        $this->configuracion = Configuracion::first();

    }


    //Crea las relaciones
    public function Crear(User $user)
    {


        $this->user = $user;

        if ($user->email_super===null){
            return false;
        }

        //$user = User::where('email',$user->email)->first();

        $supervisor= User::where('email',$user->email_super)->first();

        $evaluadores[]=['name'=>$supervisor->name,'email'=>$supervisor->email,'user_id=>'=>$supervisor->id];
        $this->supervisor=$supervisor;

        $manager= User::where('email',$supervisor->email_super)->first();
        $evaluadores[]=['name'=>$manager->name,'email'=>$manager->email,'user_id'=>$manager->id];
        $this->manager=$manager;

        //Equipo de trabajo
        $this->team = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['active', '=', true]
        ])->get();

        //Subordinados
        $this->subordinados = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['email_super', '=', $user->email],
        ])->get();

        //Pares
        $this->pares = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['email_super', '=', $supervisor->email],
            ['email', '<>', $supervisor->email],
            ['id', '<>', $user->id],
        ])->get();


    }

    /**
     * Retorna el Manager
     */
    public function getManager()
    {
       return $this->manager;
    }

    /**
     * Retorna el supervidor directo
     */
    public function getSupervisor()
    {
       return $this->supervisor;
    }

    /**
     * Retorna los subordinados
     */
    public function getSubordinados()
    {
       return $this->subordinados;
    }

    /**
     * Retorna los pares
     */
    public function getPares()
    {
       return $this->pares;
    }

    /**
     * Retorna el equipo
     */
    public function getTeam()
    {
       return $this->team;
    }

    /**
     * Retorna los evaluadores del usuario
     */
    public function getEvaluadores()
    {


        $manager = $this->manager;
        $evaluadores[]=['name'=>$manager->name,'email'=>$manager->email,'user_id=>'=>$manager->id,'relations'=>$this->configuracion->manager];

        $supervisor = $this->supervisor;
        $evaluadores[]=['name'=>$supervisor->name,'email'=>$supervisor->email,'user_id=>'=>$supervisor->id,'relations'=>$this->configuracion->supervisor];

        $pares = $this->pares;
        foreach ($pares as $item) {
            $evaluadores[]=['name'=>$item->name,'email'=>$item->email,'user_id=>'=>$item->id,'relations'=>$this->configuracion->pares];
        }

        $subor = $this->subordinados;

        foreach ($subor as $item) {
            $evaluadores[]=['name'=>$item->name,'email'=>$item->email,'user_id=>'=>$item->id,'relations'=>$this->configuracion->subordinados];
        }
        return collect($evaluadores);
    }

    public function getMetodos()
    {

        $evaluadores[] = $this->supervisor;
        $evaluadores[] = $this->manager;
        $metodo=[];

        if (count($evaluadores)>1 && $this->pares->count()>1 && $this->subordinados->count()>1){
            $metodo[]='360';
        }

        if (count($evaluadores)>1 && $this->pares->count()>1){
            $metodo[]='180';
        }

        if (count($evaluadores)>1){
            $metodo[]='90';
        }

        return $metodo;

    }

    /**
     * Genera la evaluacion de un evaluado
     */
    public function CreaEvaluacion($metodo,$subproyecto,$autoevaluacion)
    {

        $user = $this->user;

        $evaluadores[] = $this->supervisor;
        $evaluadores[] = $this->manager;

        $manager = $this->manager;
        $supervisor= $this->supervisor;
        $pares = $this->pares;
        $subordinados= $this->subordinados;

        //Metodo de 90 grados
        if (($metodo=='90' && count($evaluadores)>1)
        || ($metodo=='180' && count($evaluadores)>1 && $pares->count()>1)
        || ($metodo=='360' && count($evaluadores)>1 && $pares->count()>1 && $subordinados->count()>1)){

            //Creamos el evaluado
            $evaluado= new Evaluado();
            $evaluado->name=$user->name;
            $evaluado->status=0;
            $evaluado->word_key= $metodo;
            $evaluado->cargo_id=$user->cargo_id;
            $evaluado->subproyecto_id=$subproyecto;
            $evaluado->user_id=$user->id;
            $evaluado->save();

            //Cuando no existe un nivel superior
            if ($manager->email != $supervisor->email){
                $emanager = new Evaluador();
                $emanager->name = $manager->name;
                $emanager->email = $manager->email;
                $emanager->relation = ($metodo=='90' ? $this->configuracion->manager :$this->configuracion->supervisores);
                $emanager->remember_token = Str::random(32);
                $emanager->status = 0;
                $emanager->user_id = $manager->id;
                $evaluado->evaluadores()->save($emanager);
            }

            $esuper= new Evaluador();
            $esuper->name = $supervisor->name;
            $esuper->email = $supervisor->email;
            $esuper->relation = ($metodo=='90' ? $this->configuracion->supervisor : $this->configuracion->supervisores);
            $esuper->remember_token = Str::random(32);
            $esuper->status = 0;
            $esuper->user_id = $supervisor->id;
            $evaluado->evaluadores()->save($esuper);

            //AutoEvaluacion

            if ($autoevaluacion){
                $autoeva= new Evaluador();
                $autoeva->name = $user->name;
                $autoeva->email = $user->email;
                $autoeva->relation = $this->configuracion->autoevaluacion;
                $autoeva->remember_token = Str::random(32);
                $autoeva->status = 0;
                $autoeva->user_id = $user->id;
                $evaluado->evaluadores()->save($autoeva);

            }

        }

        //Generamos los pares
        if (($metodo=='180' && count($evaluadores)>1 && $pares->count()>1)
        || ($metodo=='360' && count($evaluadores)>1 && $pares->count()>1 && $subordinados->count()>1)){

            foreach ($pares as $par) {
                $npar= new Evaluador();
                $npar->name = $par->name;
                $npar->email = $par->email;
                $npar->relation = $this->configuracion->pares;
                $npar->remember_token = Str::random(32);
                $npar->status = 0;
                $npar->user_id = $par->id;
                $evaluado->evaluadores()->save($npar);
            }

        }

        //Generamos los subordinados
        if ($metodo=='360' && count($evaluadores)>1 && $pares->count()>1 && $subordinados->count()>1){

            foreach ($subordinados as $sub) {
                $nsub= new Evaluador();
                $nsub->name = $sub->name;
                $nsub->email = $sub->email;
                $nsub->relation = $this->configuracion->subordinados;
                $nsub->remember_token = Str::random(32);
                $nsub->status = 0;
                $nsub->user_id = $sub->id;
                $evaluado->evaluadores()->save($nsub);
            }

        }

        return true;

    }



}
