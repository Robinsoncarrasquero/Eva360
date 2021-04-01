<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use App\Departamento;
use App\Evaluado;
use App\FeedBack;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;

class FeedBackController extends Controller
{

    /*
    * Edit el Feedback de la evaluacion
    */
    public function edit($evaluado_id)
    {
        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //instanciamos un objeto de data personal
        $loteEvaluados[]=$evaluado_id;
        $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();

        //Generamos las competencias del Feedback
        foreach ($dataSerie as $key=>$dataValue){

            $competencia=$dataValue['name'];
             //Creamos un usuario para responder la prueba con autenticacion
             if ($dataValue['data'][0]>($dataValue['data'][1])){
                try {
                    $feedbacks = FeedBack::firstOrCreate(
                        ['competencia'=> $competencia],[
                        'evaluado_id' => $evaluado_id,
                        'fb_status' => 'No_Cumplida',

                    ]);
                    $feedbacks->save();

                }catch(QueryException $e) {
                    return \false;
                    abort(404,$e);
                }

             }

        }

        $fb_status=['Cumplida','No_Cumplida'];
        $feedbacks= $evaluado->feedback()->get();

        if (!$dataSerie){
            \abort(404);
        }
        return \view('feedback.edit',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status','feedbacks'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formrequest, $id)
    {
        //

        $evaluado = Evaluado::find($id);
        $user= $evaluado->evaluado;

        try {


            //Creamos los grados con las preguntas
            $fb_competencia=$formrequest->input('fb_competencia.*');
            $fb_feedback=$formrequest->input('fb_feedback.*');
            $fb_finicio=$formrequest->input('fb_finicio.*');
            $fb_ffinal=$formrequest->input('fb_ffinal.*');
            $fb_nota=$formrequest->input('fb_nota.*');
            $fb_status=$formrequest->input('fb_status.*');
            for ($i=0; $i < count($fb_competencia); $i++) {
                $fb= FeedBack::find($fb_competencia[$i]);
                $fb->feedback=$fb_feedback[$i];
                $fb->fb_finicio=$fb_finicio[$i];
                $fb->fb_ffinal=$fb_ffinal[$i];
                $fb->fb_nota=$fb_nota[$i];
                $fb->fb_status=$fb_status[$i];

                $fb->save();
            }

        } catch (QueryException $e) {
            Alert::error('Competencia '.$formrequest->competencia,Arr::random(['Duplicada','Registro Ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }



        return \redirect()->route('talent.historicoevaluaciones',$evaluado->user_id)->withSuccess('FeedBack Actualizado con exito');
    }

    /**
     * Remove el feedback de la tabla.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$fb_id)
    {
        $feedback = FeedBack::find($fb_id);
        //dd($fb_id,$feedback);
        try {
            $feedback->delete();
            $success = true;
            $message = "Feedback eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
      	    $message = "No se puede eliminar este Feedback, data restringida";
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este Feedback, tiene restricciones con la Evaluacion realizada.');
        }

        // //  Return response
        // return response()->json([
        //     'success' => $success,
        //     'message' => $message,
        // ]);

        return \redirect()->route('feedback.edit',$feedback->evaluado_id)->withSuccess('FeedBack eliminado con exito');

    }

}
