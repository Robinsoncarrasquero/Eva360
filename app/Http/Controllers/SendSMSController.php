<?php

namespace App\Http\Controllers;

use app\CustomClass\EnviarSMS;
use App\Evaluador;
use App\Notifications\WelcomeSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Nexmo\Laravel\Facade\Nexmo;

class SendSMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcome($id)
    {

        $user =  Auth::user();

        //EnviarSMS::SendSMSFacade(18);
        $evaluador= Evaluador::find($id);
        EnviarSMS::SendtoEvaluador($evaluador);
        // $r=Nexmo::message()->send([
        //     'to'   => '584166123809',
        //     'from' => '584122606283',
        //     'text' => 'Using the facade to send a message app Talent360 Test Only.'
        // ]);

        // $sms = new WelcomeSMS($user);
        // dd($sms);
        // send notification using the "user" model, when the user receives new message

        // send notification using the "Notification" facade
       // Notification::send(new WelcomeSMS($user));
        return response('Enviado 416');
    }

    public function welcomeFacade()
    {

        $sendsms = new EnviarSMS();
        $sendsms->smsFacade('584122606283','584166123809','Prueba desde Facade Cliente sms');
        // $r=Nexmo::message()->send([
        //     'to'   => '584166123809',
        //     'from' => '584122606283',
        //     'text' => 'Using the facade to send a message app Talent360 Test Only.'
        // ]);


        return response('SMS enviado desde 412');
    }

    public function sendSMS()
    {
        // $basic  = new \Nexmo\Client\Credentials\Basic('5e39cbb5', 'zA0iYXaeeE51uP8R');
        // $client = new \Nexmo\Client($basic);

        // $message = $client->message()->send([
        //     'to' => '584122606283',
        //     'from' => 'Vonage APIs',
        //     'text' => 'Hello from Vonage SMS API'
        // ]);
    }

}
