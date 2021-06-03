<?php

namespace app\CustomClass;

use App\Configuracion;
use App\EmailSend;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use App\Mail\EvaluacionEnviada;
use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EnviarEmail
{

    /** Envia los correos de invitacion a los evaluadores */
    public static function enviarEmailEvaluadores($evaluado_id){

        //Obtenemos la configuracion particular
        $configuraciones = Configuracion::first();
        if (!$configuraciones->email){
            return false;
        }

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Iteramos los evaluadores
        foreach($evaluadores as $evaluador){
            EnviarEmail::enviarEmailEvaluador($evaluador->id);
        }

        return true;

    }


    /** Enviar email de invitacion a Evaluador para responder questionario */
    public static function enviarEmailEvaluador($evaluador_id){

        //Obtenemos la configuracion particular
        $configuraciones = Configuracion::first();
        if (!$configuraciones->email){
            return false;
        }

        //Buscamos el evaluador
        $evaluador = Evaluador::find($evaluador_id);

        //Buscamos el evaluado del evaluador
        $evaluado = Evaluado::find($evaluador->evaluado_id);

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
            $evaluador->user_id = $user->id;
            $evaluador->save();

        }catch(QueryException $e) {
            return \false;
            abort(404,$e);
        }

        $receivers = $evaluador->email;

        //Creamos un objeto para pasarlo a la clase Mailable
        $data = new EmailSend();
        $data->nameEvaluador=$evaluador->name;
        $data->relation =$evaluador->relation;
        $data->email =$evaluador->email;
        //$data->linkweb =$root."/evaluacion/$evaluador->remember_token/evaluacion";
        if ($evaluado->word_key=='Objetivos'){
            $data->linkweb =Route('objetivo.token',$evaluador->remember_token);
        }else {
            $data->linkweb =Route('evaluacion.token',$evaluador->remember_token);
        }
        $data->nameEvaluado =$evaluado->name;
        $data->enviado =false;
        $data->save();
        try {
            Mail::to($receivers)->send(new EvaluacionEnviada($data,'mails.evaluacion-enviada'));
            $data->enviado =true;
            $data->save();
        }catch(QueryException $e) {
            return \false;
            abort(404);
        }

        return true;
    }

    /** Envia el correo de finalizacion de la prueba al administrador */
    public static function enviarEmailFinal($evaluado_id){

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        $receivers = env("MAIL_FROM_ADDRESS");
        $x=env('MAIL_FROM_ADDRESS', false);

        // $environment =  App::environment();
        // $receivers=App::environment("MAIL_FROM_ADDRESS");
        // dd($receivers);
        //Creamos un objeto para pasarlo a la clase Mailable
        $data = new EmailSend();
        $data->nameEvaluador="Administrador";
        $data->relation ="Admin";
        $data->email =env("MAIL_FROM_ADDRESS");

        //$data->linkweb =$root."/resultados/$evaluado_id/finales";
        $data->linkweb =Route('resultados.charindividual',$evaluado_id);
        $data->nameEvaluado =$evaluado->name;
        $data->enviado =false;
        $data->save();
        try {
            Mail::to($receivers)->send(new EvaluacionEnviada($data,'mails.evaluacion-finalizada'));
            $data->enviado =true;
            $data->save();

        }catch(QueryException $e) {
            abort(404);
        }
        return true;

    }

}
