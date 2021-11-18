<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class DataResultadoTipo{
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
    public function procesarData()
    {
        $data=$this->crearData();

    }

    /**
    * Generamos la data individual de la evaluacion obtenida por cada competencia
    */
    private function crearData()
    {

        $dataEvaluacion = new $this->objDataEvaluacion($this->proyecto_id);
        $competencias = $dataEvaluacion->getDataEvaluacionTipo();
        $this->dataFortalezaOportunidad = $dataEvaluacion->getDataFortalezaOptunidad();
        $arrayDataSerie=[];
        $arrayDataCategoria=[];
        $arrayData=[];
        $arrayCategoria2=[];
        $arrayData2=[];
        $i=0;


        foreach ($competencias as $key => $value) {
            //Creamos una array con la data de los averages
            $arrayCategoria2=[];
            $arrayData2=[];
            $arrayData3=[];
            foreach ($value['data'] as $vtipo) {
                $arrayData[] =[$vtipo['average']];
                $arrayDataCategoria[] =$value['tipo']."<br>".$vtipo['competencia'];
                $arrayCategoria2[]=$vtipo['competencia'];
                $arrayData2[] =[$vtipo['average']];
                $arrayData3[]=['name'=>$vtipo['competencia'],'data'=>[$vtipo['average']]];
            }
            $arrayDataCategoria3[]=[$value['tipo']];
            $arrayDataSerie3[]=$arrayData3;

            $arrayDataSerie2[] =['name'=> $value['tipo'],'data'=>$arrayData2,'color'=>$this->getColor($i)];
            $i++;
            $arrayDataCategoria2[]=$arrayCategoria2;
        }

        $arrayDataSerie[] =['name'=> 'Competencias','data'=>$arrayData];
        $this->dataSerie=$arrayDataSerie3;
        $this->dataCategoria=$arrayDataCategoria3;

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

            'rgb(255, 255, 0)',
            'rgb(128, 0, 0)',
            'rgb(255, 0, 0)',
            'rgb(0, 0, 0)',
            'rgb(0, 255, 255)',
            'rgb(0 ,128, 0)',
            'rgb(0, 255, 0)',
            'rgb(128, 128, 128)',
            'rgb(128, 128, 0)',
            'rgb(214, 137, 16)',
            'rgb(128, 0, 128)',
            'rgb(0, 0, 128)',
            'rgb(0, 0, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            'rgb(0, 0, 255)',
            'rgb(0, 128, 128)',
            ];
        $index=rand(0,count($color)-1);
        return $color[$index];
    }

}
