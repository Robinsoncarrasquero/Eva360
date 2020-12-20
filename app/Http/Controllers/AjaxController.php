<?php

namespace App\Http\Controllers;

use app\CustomClass\EnviarEmail;
use App\Evaluador;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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
            $objEnviarEmailEvaluador = new EnviarEmail();
            $objEnviarEmailEvaluador->enviarEmailEvaluador($evaluador_id);
            $objEnviarEmailEvaluador=null;
            return response()->json(['success'=>true,'message'=>'Cuestionario ha sido enviado ...','errors'=>["email"=>"Email ha sido enviado"]]);
         }
         return response()->json(['success'=>false,'message'=>"ERROR, no se envio el cuestionario ",'errors'=>["email"=>"ERROR Re-enviando email"]]);
     }

     /** Cambiar e-mail de Evaluador despues de lanzada una prueba*/
     public function changeEmailEvaluador(Request $request)
     {
        $evaluador_id=$request->id;
        $root=$request->root();
        $email_new=$request->email;
        if ($request->id>0) {
            $evaluador = Evaluador::find($evaluador_id,['id','email','user_id']);
            $user = User::find($evaluador->user_id, ['id', 'email']);

            //creamos un validador
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
            try {
                $user->email = $email_new;
                $user->save();
            }catch(QueryException $e) {
                return response()->json(['success'=>false,'message'=>'Error e-mail ya ha sido tomado por otro usuario ...','errors'=>["email"=>"The email ha sido tomado por otro usuario."]]);
                abort(404,$e);
            }

            //Buscamos los evaluadores del evaluado
            $evaluadores = User::find($evaluador->user_id)->evaluaciones;

            //Iteramos los evaluadores
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
            return response()->json(['success'=>true,'message'=>'Email modificado con exitosamente....','errors'=>["email"=>"El e-mail ha sido modificado con exito."]]);
        }
     }

}
