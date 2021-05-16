<?php

namespace App\Exports;

use app\CustomClass\DataEvaluacion;
use app\CustomClass\DataObjetivo;
use app\CustomClass\DataPersonal;
use App\Evaluado;
use App\FeedBack;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FeedBackExport implements FromView
{
    private $evaluado;

    public function __construct(Evaluado $evaluado)
    {
        $this->evaluado = $evaluado;
    }

    public function view(): View
    {

        $feedbacks=  $this->evaluado->feedback;
        $evaluado= $this->evaluado;
        $loteEvaluados[]=$evaluado->id;
        $objData = new DataPersonal($loteEvaluados,$evaluado->word_key=="Objetivos" ? new DataObjetivo(0) : new DataEvaluacion(0));
        $objData->procesarData();
        $dataSerie = $objData->getDataSerie();

        $fbs=$feedbacks->all();
        foreach ($dataSerie as $key => $value) {

            foreach ($fbs as $fb) {

                if ($value['name']==$fb->competencia){
                    $datafbs[] = ['name'=>$fb->competencia,'feedback'=>$fb->feedback,
                    'fb_finicio'=>$fb->fb_finicio,
                    'fb_ffinal'=>$fb->fb_ffinal,
                    'fb_nota'=>$fb->fb_nota,
                    'fb_status'=>$fb->fb_status,
                    'data'=>$value['data']];
                }
            }
        }
        if ($fbs){
           return view('exports.feedbacks',\compact('feedbacks','evaluado','dataSerie','datafbs'));
        }
        \abort(404);

    }
}

