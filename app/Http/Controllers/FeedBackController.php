<?php

namespace App\Http\Controllers;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataObjetivo;
use app\CustomClass\DataObjetivoPersonal;
use app\CustomClass\DataPersonal;
use app\CustomClass\DataResultado;
use App\Departamento;
use App\Evaluado;
use App\Exports\FeedBackExport;
use App\Exports\UsersExport;
use App\FBstatu;
use App\FeedBack;
use App\Periodo;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;



class FeedBackController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formrequest, $id)
    {
        $evaluado = Evaluado::find($id);

        try {
            //Update a los feeedback
            $fb_competencia=$formrequest->input('fb_competencia.*');
            $fb_feedback=$formrequest->input('fb_feedback.*');
            $fb_finicio=$formrequest->input('fb_finicio.*');
            $fb_ffinal=$formrequest->input('fb_ffinal.*');
            $fb_nota=$formrequest->input('fb_nota.*');
            $fb_status=$formrequest->input('fb_status.*');
            $fb_periodo=$formrequest->input('fb_periodo.*');
            $fb_development=$formrequest->input('fb_development.*');

            for ($i=0; $i < count($fb_competencia); $i++) {
                $fb= FeedBack::find($fb_competencia[$i]);
                $fb->feedback=$fb_feedback[$i];
                $fb->fb_finicio=$fb_finicio[$i];
                $fb->fb_ffinal=$fb_ffinal[$i];
                $fb->fb_nota=$fb_nota[$i];
                $fb->periodo_id=$fb_periodo[$i];
                $fb->fbstatu_id=$fb_status[$i];
                $fb->development=$fb_development[$i];
                $fb->save();

            }

        } catch (QueryException $e) {
            Alert::error('Competencia '.$formrequest->competencia,Arr::random(['Duplicada','Registro Ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }

        if (Auth::user()->is_manager){

            return \redirect()->route('manager.staff',$evaluado->subproyecto_id)->withSuccess('FeedBack Actualizado con exito');
        }
        return \redirect()->route('talent.historicoevaluaciones',$evaluado->user_id)->withSuccess('FeedBack Actualizado con exito');
    }

    /**
     * Exportar feedback en Excel de un evaluado.
     *
     */

   public function exportFeedBack(Evaluado $evaluado)
    {
        return Excel::download(new FeedBackExport($evaluado), 'FeedBackExport.xlsx');
    }

     /*
    * Edit Feedback de una evaluacion
    */
    public function edit($evaluado_id)
    {

        //Buscamos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //instanciamos un objeto de data personal
        $loteEvaluados[]=$evaluado_id;
        if ($evaluado->word_key=="Objetivos"){
            $objData = new DataObjetivoPersonal($loteEvaluados,new DataObjetivo(0));
        }
        else {
            $objData = new DataPersonal($loteEvaluados,new DataEvaluacion(0));
        }
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();
        $dataCategoria = $objData->getDataCategoria();
        $dataBrecha = $objData->getDataBrecha();
        //dd($dataSerie,$dataBrecha,$dataCategoria);


        //Generamos las competencias del Feedback
        foreach ($dataSerie as $key=>$dataValue){

            $competencia=$dataValue['name'];
             //Modelo > resultado genera feedback
             //if ($dataValue['data'][0]>($dataValue['data'][1]))

             if ($dataValue['name']!=='Promedio' && ($dataValue['data'][0]>$dataValue['data'][1])){
                //dd($competencia);
                $feedbacks = FeedBack::firstOrCreate(
                    ['competencia'=> $competencia,
                    'evaluado_id' => $evaluado_id],
                    [
                //    'fb_status' => ($dataValue['data'][0]>($dataValue['data'][1]) ? 'No_Cumplida' : 'Cumplida')
                    ]
                );

             }

        }

        $fb_status=['Cumplida','No_Cumplida'];
        $fb_status= FBstatu::all();

        $feedbacks= $evaluado->feedback()->get();
        $periodos = Periodo::all();
        if (!$dataSerie){
            \abort(404);
        }

        switch ($evaluado->word_key) {
            case 'Objetivos':
                return \view('feedback.fbeditobjetivo',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status','feedbacks'));
                break;

            default:
                return \view('feedback.fbedit',compact("dataSerie","dataCategoria","dataBrecha","evaluado",'fb_status','feedbacks','periodos'));
            break;
        }

    }



}
