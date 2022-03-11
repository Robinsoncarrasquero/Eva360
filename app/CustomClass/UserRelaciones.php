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
use Throwable;

class UserRelaciones
{
    private $user;
    private $subordinados;
    private $pares;
    private $manager;
    private $supervisor;
    private $team;
    private $clientes;
    private $configuracion;
    function __construct() {
        //Obtenemos la configuracion particular
        $this->configuracion = Configuracion::first();

    }


    //Crea las relaciones
    public function Crear(User $user)
    {


        $this->user = $user;


        if ($user->email_super==null){
            return false;
        }

        try {

            $supervisor= User::where('email',$user->email_super)->first();

            $evaluadores[]=['name'=>$supervisor->name,'email'=>$supervisor->email,'user_id=>'=>$supervisor->id];
            $this->supervisor=$supervisor;

            $manager= User::where('email',$supervisor->email_super)->first();
            $evaluadores[]=['name'=>$manager->name,'email'=>$manager->email,'user_id'=>$manager->id];
            $this->manager=$manager;
        } catch (Throwable $e) {
            return false;
        }

        //Equipo de trabajo
        $this->team = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['active', '=', true]
        ])->get();

        //Subordinados
        $this->subordinados = DB::table('users')->where([
            //['departamento_id', '=', $user->departamento_id],
            ['email_super', '=', $user->email],
        ])->get();

        //Pares
        $pares_directos = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['email_super', '=', $supervisor->email],
            ['email', '<>', $supervisor->email],
            ['id', '<>', $user->id],
        ])->get();

        $idpares_directos=$pares_directos->pluck('id');

        $pares_indirectos = DB::table('pares')->where('user_id',$user->id)->get();
        $idpares_indirectos=$pares_indirectos->pluck('user_id_par');

        $id_pares_concatenated = $idpares_indirectos->concat($idpares_directos)->unique();

        $this->pares = User::whereIn('id',$id_pares_concatenated)->get();

        //$this->clientes = DB::table('pares')->where('user_id',$user->id)->where('relation','clientes')->get();


        return true;

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
     * Retorna el equipo
     */
    public function getClientes()
    {
       return $this->clientes;
    }

    /**
     * Retorna los evaluadores del usuario
     */
    public function getEvaluadores(){

        try {
           $manager = $this->manager;
           $evaluadores[]=['name'=>$manager->name,'email'=>$manager->email,'user_id=>'=>$manager->id,'relations'=>$this->configuracion->manager];

            $supervisor = $this->supervisor;
            $evaluadores[]=['name'=>$supervisor->name,'email'=>$supervisor->email,'user_id=>'=>$supervisor->id,'relations'=>$this->configuracion->supervisor];

        } catch (Throwable $e) {
            return false;
        }

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


        if (count($evaluadores)>=1 && $this->pares->count()>1 && $this->subordinados->count()>1){
            $metodo[]='360';
        }

        if (count($evaluadores)>=1 && $this->pares->count()>1){
            $metodo[]='180';
        }

        if (count($evaluadores)>=1){
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
        if (($metodo=='90' && count($evaluadores)>=1)
        || ($metodo=='180' && count($evaluadores)>=1 && $pares->count()>1)
        || ($metodo=='360' && count($evaluadores)>=1 && $pares->count()>1 && $subordinados->count()>1)){

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
            if ($manager && $manager->email != $supervisor->email){
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
        if (($metodo=='180' && count($evaluadores)>=1 && $pares->count()>1)
        || ($metodo=='360' && count($evaluadores)>=1 && $pares->count()>1 && $subordinados->count()>1)){

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
        if ($metodo=='360' && count($evaluadores)>=1 && $pares->count()>1 && $subordinados->count()>1){

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

    //Crea las relaciones de forma libre y setea las relaciones o roles
    public function GeneraData($lista_de_evaluadores)
    {

        $user= $this->user;

        if ($user->email_super===null){
            return false;
        }
        $subordinados=[];
        $pares=[];
        $this->manager='';
        $this->supervisor='';

        foreach ($lista_de_evaluadores as $key => $record) {

            $userEvaluador= User::where('email',$record['email'])->first();

            if ($userEvaluador){

                if ($record['relation']==$this->configuracion->supervisor) {
                    $this->supervisor=$userEvaluador;
                }

                if ($record['relation']==$this->configuracion->manager) {
                    $this->manager=$userEvaluador;
                }

                if ($record['relation']==$this->configuracion->pares) {
                    $pares[]= $userEvaluador->id;
                }

                if ($record['relation']==$this->configuracion->subordinados) {
                    $subordinados[]= $userEvaluador->id;
                }
            }
        }

        //Equipo de trabajo
        $this->team = DB::table('users')->where([
            ['departamento_id', '=', $user->departamento_id],
            ['active', '=', true]
        ])->get();


        //Pares
        $this->pares = DB::table('users')->whereIn('id',$pares)->get();

        //Subordinados
        $this->subordinados =  DB::table('users')->whereIn('id',$subordinados)->get();

        return true;

    }

    public function getValidaMetodo($metodoaprocesar)
    {

        $evaluadores[] = $this->supervisor;
        $evaluadores[] = $this->manager;
        $metodo=[];

        if ($metodoaprocesar="360" && count($evaluadores)>=1 && $this->pares->count()>1 && $this->subordinados->count()>1){
            return true;
        }

        if ($metodoaprocesar="180" && count($evaluadores)>=1 && $this->pares->count()>1){
            return true;
        }

        if ($metodoaprocesar="90" && count($evaluadores)>=1){
            return true;
        }

        return false;

    }

    //cambia email del supervisores y evaluadores
    public function cambia_email(User $user, $email_new)

    {

        //Actualiza email user
        try {
            $email_old = $user->email;
            $user->email = $email_new;
            $user->save();

            //Actualiza colaboradores que reportan al usuarios
            DB::table('users')->where('email_super', $email_old)->update(['email_super' => $email_new]);

        }catch(QueryException $e) {
            return response()->json(['success'=>false,'message'=>'Error e-mail ya ha sido tomado por otro usuario ...','errors'=>["email"=>"The email ha sido tomado por otro usuario."]]);
            abort(404,$e);
        }

        //Buscamos todas las evaluaciones de un usuario evaluador
        $evaluadores = $user->evaluadores;

        //Cambiamos el email de las evaluaciones del evaluador
        foreach($evaluadores as $evaluadorx){
            //Actualizamos el email del evaluador
            try {

                $evaluadorx->email=$email_new;
                $evaluadorx->save();

            }catch(QueryException $e) {

                return response()->json(['success'=>false,'message'=>'Error Fatal intentando modificar Email de Evaluador, reporte este incidente.','errors'=>["email"=>"The email ha sido tomado por otro usuario."]]);
                abort(404,$e);
            }
        }
    }



}
