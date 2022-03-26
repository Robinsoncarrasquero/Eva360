<?php
namespace app\CustomClass;

use App\Configuracion;
use App\Evaluado;
use App\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class DataResultadoDpto{
    private $dataSerie;
    private $dataCategoria;
    private $proyecto_id;
    private $objDataEvaluacion;
    private $dataFortalezaOportunidad;

    function __construct($proyecto_id,$dataEvaluacion) {
        $this->proyecto_id = $proyecto_id;
        $this->objDataEvaluacion=$dataEvaluacion;
    }

    /**
     * Procesa los resultados por proyecto
     */
    public function procesarData($modelo)
    {
        $data=$this->crearData($modelo);

    }

    /**
    * Generamos la data individual de la evaluacion obtenida por cada competencia
    */
    private function crearData($modelo)
    {
        $color =[
            'rgb(128, 128, 0)',
            'rgb(214, 137, 16)',
            'rgb(128, 0, 128)',
            'rgb(0, 0, 128)',
            'rgb(255, 0, 255)',
            'rgb(0, 0, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            'rgb(0, 255, 255)',
            'rgb(0 ,128, 0)',
            'rgb(0, 255, 0)',
            'rgb(128, 128, 0)',
            'rgb(255, 255, 0)',
            'rgb(128, 0, 0)',
            'rgb(255, 0, 0)',
            'rgb(0, 0, 0)',
            'rgb(128, 128, 128)',
            ];
        $dataEvaluacion = new $this->objDataEvaluacion($this->proyecto_id);
        $competencias = $dataEvaluacion->getDataEvaluacionDpto();
        $this->dataFortalezaOportunidad = $dataEvaluacion->getDataFortalezaOptunidad();
        $arrayDataSerie=[];
        $arrayDataCategoria=[];
        $arrayData=[];
        $arrayCategoria2=[];
        $arrayData2=[];
        $i=0;
        dd($competencias);
        foreach ($competencias as $key => $value) {
            //Creamos una array con la data de los averages
            $arrayCategoria2=[];
            $arrayData2=[];
            $arrayData3=[];
            foreach ($value['data'] as $vdata) {
                $arrayData[] =[$vdata['average']];
                $arrayDataCategoria[] =$value['nivel']."<br>".$vdata['competencia'];
                $arrayCategoria2[]=$vdata['competencia'];
                $arrayData2 []=[$vdata['average']];
                //Metiendo modelo
                if ($modelo){
                    $arrayData3[]=['name'=>$vdata['competencia'],'data'=>[$vdata['average'],$vdata['nivel']]];
                }else{
                    $arrayData3[]=['name'=>$vdata['competencia'],'data'=>[$vdata['average']]];
                }
              }
            //Metiendo Modelo
            if ($modelo){
                $arrayDataCategoria3[]=[$value['nivel'],'Modelo'];
            }else{
                $arrayDataCategoria3[]=[$value['nivel']];
            }
            $arrayDataSerie3[]=$arrayData3;

            $arrayDataSerie2[] =['name'=> $value['nivel'],'data'=>$arrayData2,'color'=>$this->getColor($i)];
            $i++;
            $arrayDataCategoria2[]=$arrayCategoria2;
        }

        $arrayDataSerie[] =['name'=> 'Competencias','data'=>$arrayData,'color'=>'rgb(75,0,130)'];
        $this->dataSerie=$arrayDataSerie2;
        $this->dataCategoria=$arrayDataCategoria2;
        return ['categoria'=>$arrayDataCategoria3,'data'=>$arrayDataSerie3];
    }

    /**Data de la serie */
    public function getDataSerie(){
        return $this->dataSerie;
    }

    /**Data de la categoria */
    public function getDataCategoria(){
        return $this->dataCategoria;
    }

    /**Obtenemos los datos de Fortalezas y Oportunidades */
    public function getDataFortalezaOptunidad(){
        return $this->dataFortalezaOportunidad;
    }

    public function getColor($index)
    {
        $color =[
            'rgb(128, 128, 0)',
            'rgb(214, 137, 16)',
            'rgb(128, 0, 128)',
            'rgb(0, 0, 128)',
            'rgb(0, 0, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            'rgb(0, 255, 255)',
            'rgb(0 ,128, 0)',
            'rgb(0, 255, 0)',
            'rgb(128, 128, 0)',
            'rgb(128, 0, 0)',
            'rgb(255, 0, 0)',
            'rgb(0, 0, 0)',
            'rgb(128, 128, 128)',
            ];
        $index=rand(0,count($color)-1);
        return $color[$index];
    }


}
