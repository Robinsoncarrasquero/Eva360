<?php


namespace App\Http\Controllers;

use App\Evaluador;
use Illuminate\Support\Facades\Mail;

use App\Mail\EmergencyCallReceived;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    //
    public function contact(Request $request)
    {
        dd($request->all());
        $subject = "Asunto del correo";
        $for = "rcarrasquero@gmail.com";
        Mail::send('email', $request->all(), function ($msj) use ($subject, $for) {
            $msj->from("robinson.carrasquero@gmail.com", "Robinson Director");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }
    //Esta ruta la ponemos en la raiz para que nada mas ejecutar nuestra aplicación aparezca nuestro formulario
    public function emailtest()
    {
        return view('test');
    }

    public function emailsend()
    {

        Mail::send('emails.welcome', ['key' => 'value'], function ($message) {
            $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
        });



    }

    public function email_file(Request $data)
    {
        $pathToFile='';

        Mail::send('emails.welcome', $data, function($message) use($pathToFile)
        {
            $message->from('us@example.com', 'Laravel');

            $message->to('foo@example.com')->cc('bar@example.com');

            $message->attach($pathToFile);
        });
    }


    public function emergency(){
        $call= new Evaluador();
        $call->name="Roberto Carrasquero";
        $call->phone="5899220011";
        $call->dni="VDNI789908888";
        $call->lat="10.4415854";
        $call->lng="-66.8677679,15";


        //$receivers = Evaluador::pluck('email');
        $receivers= \collect(['rcarrasquero@gmail.com','robinson.carrasquero@gmail.com']);

        Mail::to($receivers)->send(new EmergencyCallReceived($call));


    }
}
