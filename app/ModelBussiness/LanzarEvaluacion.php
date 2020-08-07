<?php

namespace app\ModelBussiness;

use App\EmailSend;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Mail\EvaluacionEnviada;
use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LanzarEvaluacion
{
    private $competencias;
    private $evaluado_id;
    private $root;

    function __construct($competencias,$evaluado_id,$root) {
        $this->competencias = $competencias;
        $this->evaluado_id = $evaluado_id;
        $this->root = $root;

    }

    /** Crea la evaluacion del evaluado */
    public function crearEvaluacion(){

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($this->evaluado_id);
        //Buscamos los evaluadores del evaluado
        $evaluadores = $evaluado->evaluadores;

        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($this->competencias as $key=>$this->competencia){
                $evaluacion = new Evaluacion();
                //$evaluacion->resultado=Helper::estatus('Inicio');
                $evaluacion->competencia_id=$this->competencia->id;
                try {
                    //Salvamos a la evaluacion
                    $eva360=$evaluador->evaluaciones()->save($evaluacion);

                    //Cambiamos status de Evaluado
                    $evaluadorx = Evaluador::find($evaluador->id);
                    $evaluadorx->status=1; //0:Inicio, 1:Lanzada 2:finalizada
                    $evaluadorx->save();

                } catch (QueryException $e) {
                    return false;
                }
            }

        }

        $this->enviarEmailEvaluadores($this->evaluado_id,$this->root);
        return true;
    }

    /** Envia los correos de invitacion a los evluadores */
    public function enviarEmailEvaluadores($evaluado_id,$root){

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Iteramos los evaluadores
        foreach($evaluadores as $evaluador){

            //Creamos un usuario para responder la prueba con autenticacion
            try {
                $user = User::firstOrCreate(
                    ['email'=>$evaluador->email],[
                    'name' => $evaluador->name,
                    'password' => Hash::make('secret1234')
                ]);
                if (!$user->hasRole('user')){
                    $userRole =Role::where('name','user')->first();
                    $user->roles()->attach($userRole);
                }
                $evaluadorx = Evaluador::find($evaluador->id);
                $evaluadorx->user_id = $user->id;
                $evaluadorx->save();

            }catch(QueryException $e) {

                abort(404,$e);
            }

            $receivers = $evaluador->email;

            //Creamos un objeto para pasarlo a la clase Mailable
            $data = new EmailSend();
            $data->nameEvaluador=$evaluador->name;
            $data->relation =$evaluador->relation;

            $data->linkweb =$root."/evaluacion/$evaluador->remember_token/evaluacion";
            $data->nameEvaluado =$evaluado->name;
            try {

                Mail::to($receivers)->send(new EvaluacionEnviada($data));

            }catch(QueryException $e) {
                abort(404);
            }

        }

    }

}
