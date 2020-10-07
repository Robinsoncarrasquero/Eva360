<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class DataResultadoNivel{
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
        $competencias = $dataEvaluacion->getDataEvaluacionNivel();
        $this->dataFortalezaOportunidad = $dataEvaluacion->getDataFortalezaOptunidad();
        $arrayDataSerie=[];
        $arrayDataCategoria=[];
        $arrayData=[];
        foreach ($competencias as $key => $value) {
            //Creamos una array con la data de los averages
            foreach ($value['data'] as $vdata) {
                $arrayData[] =[$vdata['average']];
                $arrayDataCategoria[] =$value['nivel']."<br>".$vdata['competencia'];
            }
        }
        $arrayDataSerie[] =['name'=> 'Competencias','data'=>$arrayData,'color'=>'rgb(75,0,130)'];

        $this->dataSerie=$arrayDataSerie;
        $this->dataCategoria=$arrayDataCategoria;
        return ['categoria'=>$arrayDataCategoria,'data'=>$arrayDataSerie];
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

}
