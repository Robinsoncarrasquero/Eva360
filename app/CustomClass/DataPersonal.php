<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataPersonal{
    private $dataSerie;
    private $dataCategoria;
    private $evaluados;
    private $objDataEvaluacion;

    function __construct($evaluados,$dataEvaluacion) {
        $this->evaluados = $evaluados;
        $this->objDataEvaluacion=$dataEvaluacion;
    }
    
    /**
     * Procesa los resultados individuales de forma masiva
     */
    public function procesarData()
    {
        
        foreach ($this->evaluados as $evaluado) {
            $this->evaluado_id=$evaluado;
            $data[]=$this->crearData();
        }
        
        foreach ($data as $key => $value) {
            $arrayCategoria[]=$value['categoria'];
            
            //Creamos una array con la data de las competencias
            foreach ($value['data'] as $item) {
                $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['data']];
            }
        }
        $datacollection=collect($arrayCompetencias);
        $agrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });
        foreach ($agrouped as $key => $datavalue) {
            $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }
        
        $this->dataCategoria=$arrayCategoria;;
        $this->dataSerie=$arraydataSerie;

    }

    /**
    * Generamos la data individual de la evaluacion obtenida por cada competencia
    */
    private function crearData()
    {
       // $competencias = $this->dataCompetencias($this->evaluado_id);

        $dataEvaluacion = new $this->objDataEvaluacion($this->evaluado_id);
        $competencias = $dataEvaluacion->getDataEvaluacion();

        $arrayDataSerie=[];
        foreach ($competencias as $key => $value) {
            $arrayCompetencias[]=$value['competencia'];
            $arrayNivel[]=(int) $value['nivelRequerido'];
            $arrayEvaluacion[]=$value['eva360'];

            //Creamos una array con la data de los evaluadores
            foreach ($value['data'] as $item) {
                $arrayEvaluador[] =['name'=> $item['name'],'average'=>$item['average']];
            }
            //Creamos los datos para la serie en datos individuales
            $arrayDataSerie[] =['name'=> $value['competencia'],'data'=>$value['eva360']];

        }

        $datacollection= collect($arrayEvaluador);
        //Agrupamos la data de evaluadores para obtener una coleccion
        $evagrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['average']];
        });
        
        //Buscamos el evaluado
        $evaluado = Evaluado::find($this->evaluado_id);

        $this->dataCategoria=$evaluado->name;
        $this->dataSerie=$arrayDataSerie;
        return ['categoria'=>$evaluado->name,'data'=>$arrayDataSerie];
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
