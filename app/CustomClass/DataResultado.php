<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataResultado{
    private $evaluado_id;
    private $dataSerie;
    private $dataCategoria;
    private $objDataEvaluacion;

    function __construct($evaluado_id,$dataEvaluacion) {
        $this->evaluado_id = $evaluado_id;
        $this->objDataEvaluacion=$dataEvaluacion;
    }

    /**Generamos la data para la grafica 360 */
    public function procesarData()
    {
        $dataEvaluacion = new $this->objDataEvaluacion($this->evaluado_id);
        $competencias = $dataEvaluacion->getDataEvaluacion();
        $arrayEvaluador =[];$arrayNivel=[];$arrayEvaluacion=[];$arrayCategoria=[];

        foreach ($competencias as $key => $value) {
            $arrayCategoria[]=$value['competencia'];
            $arrayNivel[]=(int) $value['nivelRequerido'];
            $arrayEvaluacion[]=$value['eva360'];

            //Creamos una array con la data de los evaluadores
            foreach ($value['data'] as $item) {
                $arrayEvaluador[] =['name'=> $item['name'],'average'=>$item['average']];
            }

        }

        $collection= collect($arrayEvaluador);
        //Agrupamos la data de evaluadores para obtener una coleccion
        $evagrouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['average']];
        });

        //Creamos un array con la data de cada serie
        foreach ($evagrouped as $key => $data) {
            $dataSerie[]=['name'=>$key,'data'=>$data];
        }

        $dataSerie[]= ['name'=>'Nivel Requerido','data'=>$arrayNivel];

        $dataSerie[]= ['name'=>'Evaluacion','data'=>$arrayEvaluacion];

        $this->dataCategoria=$arrayCategoria;
        $this->dataSerie=$dataSerie;
    }

    /**Data de la serie */
    public function getDataSerie(){

        return $this->dataSerie;
    }
    /**Data de la categoria */
    public function getDataCategoria(){
        return $this->dataCategoria;
    }

}
