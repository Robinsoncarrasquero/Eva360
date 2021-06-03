<?php

namespace app\CustomClass;

use App\Configuracion;
use App\Evaluado;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;

class EnviarSMS
{


    /** Envia los sms a los evaluadores de un evaluado */
    public static function SendSMSFacade($evaluado_id){

        //Obtenemos la configuracion particular
        $configuraciones = Configuracion::first();
        if (!$configuraciones->sms){
            return false;
        }

        //Buscamos el Evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;

        //Iteramos los evaluadores
        foreach($evaluadores as $evaluador){

            EnviarSMS::SendtoEvaluador($evaluador);
        }

    }

    /** Envia el sms a un evaluador  */
    public static function SendtoEvaluador($evaluador){

        $user = $evaluador->user;
        $evaluado = $evaluador->evaluado;
        $linkweb =Route('evaluacion.token',$evaluador->remember_token);
        // dd($linkweb);
        $to = $user->phone_number;
        //\dd($to,$user,$evaluado);
        $msg = "Estimado (a) $user->name, hemos enviado un correo para acceder a la evaluacion de $evaluado->name.  Talent 360";
        if ($to){
            Nexmo::message()->send([
                'to'   => '584122606283',
                'from' => '584122606283',
                'text' => $msg //;'Using the facade to send a message app Talent360 Test Only.'
            ]);
        }

    }

    /** Envia el sms a un telefono */
    public static function smsFacade($to,$from,$msg){
        Nexmo::message()->send([
            'to'   => $to, //'584166123809',
            'from' => $from, //'584122606283',
            'text' => $msg //;'Using the facade to send a message app Talent360 Test Only.'
        ]);

    }

}
