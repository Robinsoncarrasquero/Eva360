<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use App\Departamento;
use App\Evaluado;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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

        $fb_status=['Cumplida','No_Cumplida'];
        if (!$dataSerie){
            \abort(404);
        }
        return \view('feedback.edit',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'feedback'=>'required',
            'fb_status'=>'required',
            ],[
                'feedback.required'=>'FeedBack es requerido',
                'fb_status.required'=>'Status es requerido'
            ],

        );

        try {

            $record = Evaluado::findOrFail($id);
            $record->feedback=$request->feedback;
            $record->fb_status= $request->fb_status;
            $record->fb_nota= $request->fb_nota;
            $record->fb_finicio= $request->fb_finicio;
            $record->fb_ffinal= $request->fb_ffinal;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El feedback debe ser unico, no se permite duplicados.');
        }

        return \redirect()->route('talent.historicoevaluaciones',$record->user_id)->withSuccess('FeedBack Actualizado con exito');
    }

}
