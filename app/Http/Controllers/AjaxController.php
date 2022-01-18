<?php

namespace App\Http\Controllers;

use app\CustomClass\EnviarEmail;
use app\CustomClass\UserRelaciones;
use App\Evaluador;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    /**
     * Enviar Email a Evaluador para reponder la prueba del evaluado
     */
    public function sendEmailEvaluador(Request $request)
     {
        $evaluador_id=$request->id;
        if ($request->id>0) {
            if (EnviarEmail::enviarEmailEvaluador($evaluador_id)){
                return response()->json(['success'=>true,'message'=>'Cuestionario ha sido enviado ...','errors'=>["email"=>"Email ha sido enviado"]]);
            }
            return response()->json(['success'=>false,'message'=>"Error, no se envio el cuestionario ",'errors'=>["email"=>"ERROR no ha sido enviado email"]]);

         }
         return response()->json(['success'=>false,'message'=>"Error, no se envio el cuestionario ",'errors'=>["email"=>"ERROR Re-enviando email"]]);
     }

     /** Cambiar e-mail de Evaluador despues de lanzada una prueba*/
     public function changeEmailEvaluador(Request $request)
     {
        $evaluador_id=$request->id;
        $email_new=$request->email;

        if ($request->id>0) {
            $evaluador = Evaluador::find($evaluador_id,['id','email','user_id']);
            $user = User::find($evaluador->user_id, ['id', 'email']);
            //creamos un validador de email
            $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$user->id,
            'email' => 'email:rfc,dns',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success'=>false,'message'=>$errors->first('email'),'errors'=>["email"=>"El e-mail debe ser una direccion de correo valida"]]);
            }

            if ($user->email==$email_new){
                return response()->json(['success'=>false,'message'=>'No hay cambios que realizar...','errors'=>["email"=>"The email no ha sido modficado."]]);
            }

            //Cambiamos email nuevo de las evaluaciones del usuario evaluador
            $UserRelaciones = new UserRelaciones();
            $UserRelaciones->cambia_email($user,$email_new);

            return response()->json(['success'=>true,'message'=>'Email modificado con exitosamente....','errors'=>["email"=>"El e-mail ha sido modificado con exito."]]);
        }
     }

}
