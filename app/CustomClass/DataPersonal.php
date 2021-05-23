<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataPersonal{
    private $dataSerie;
    private $dataCategoria;
    private $evaluados;
    private $objDataEvaluacion;
    private $dataMeta;
    private $dataBrecha;
    private $dataSerieBrecha;
    private $dataCategoriaBrecha;

    function __construct($evaluados,$dataEvaluacion) {
        $this->evaluados = $evaluados;
        $this->objDataEvaluacion=$dataEvaluacion;
    }

    /**
     * Procesa los resultados individuales de forma masiva
     */
    public function procesarData()
    {
        $data=[];
        foreach ($this->evaluados as $evaluado) {
            $this->evaluado_id=$evaluado;
            $evaluado = Evaluado::find($this->evaluado_id);

            if ($evaluado->status==2){
                $data[]=$this->crearData();

            }


        }
        if($data==[]){
            $this->dataMeta=[];
            $this->dataBrecha=[];
            $this->dataCategoria=[];
            $this->dataSerie=[];
            $this->dataSerieBrecha=[];
            $this->dataCategoriaBrecha=[];
            return;
        }
        //Creamos un array con las competencias metas y su margen
        $arrayCategoria[]='Modelo';
        $dataMeta= $this->getDataMeta();
        foreach ($dataMeta as $item) {
            $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['data']];
        }
        $arraySerieBrecha=[];$arrayCategoriaBrecha=[];
        foreach ($data as $key => $value) {
            $arrayCategoria[]=$value['categoria'];

            /**
             * Creamos arreglos de control dinamico para manejar la data de oportunidad
             * y calcular el promedio de resultado
             *
            */
            //Creamos una array con la data de las competencias
            $arrayCumplimiento=[];
            $arraydataOportunidad=[];
            $arraydataFortaleza=[];
            $arrayPotencial=[];
            foreach ($value['data'] as $item) {
                $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['eva360']];
                $arrayPotencial[] =['name'=> $item['name'],'data'=>$item['eva360']];
                /**
                 * Cuando el resultado es menos que nivel requerido se genera una oportunidad de mejora
                 */
                if ($item['eva360']<$item['nivel']){
                    $arraydataOportunidad[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayCumplimiento[] =['name'=> $item['name'],'data'=>$item['eva360']];
                }else{
                    $arraydataFortaleza[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayCumplimiento[] =['name'=> $item['name'],'data'=>$item['nivel']];
                }
            }

            {
                $brecha=100;$cumplimiento=0;$potencial=0;
                if (collect($dataMeta)->avg('data')!=0){
                    $cumplimiento=collect($arrayCumplimiento)->avg('data')/collect($dataMeta)->avg('data')*100;

                    $cumplimiento=collect($arrayCumplimiento)->sum('data')/count($arrayCumplimiento);
                    $brecha= 100 - $cumplimiento;
                }

                $potencial=collect($arrayPotencial)->avg('data')/collect($dataMeta)->avg('data')*100;
                $potencial= $potencial > 100 ? $potencial : 0;
                $arraydataBrecha[]=['categoria'=>$value['categoria'],'cumplimiento'=>$cumplimiento,'brecha'=>$brecha,'dataoportunidad'=>$arraydataOportunidad,'datafortaleza'=>$arraydataFortaleza,'potencial'=>$potencial];

                //Creamos la categoria para el cumplimiento y la brecha
                $arrayCategoriaBrecha[]=[$value['categoria']];
                $arraySerieCumplimiento[]=[$cumplimiento];
                $arraySerieBrecha[]=[$brecha];
                $arraySeriePotencial[]=[$potencial];
            }

        }

        //Generar la data serie del cumpliento y la brecha
        $arraydataSerieBrecha[]=['name'=>'Cumplimiento','data'=>$arraySerieCumplimiento];
        $arraydataSerieBrecha[]=['name'=>'Brecha','data'=>$arraySerieBrecha];
        $arraydataSerieBrecha[]=['name'=>'Potencial','data'=>$arraySeriePotencial];

        //Generamos una colleccion para agrupar la data de la serie
        $datacollection=collect($arrayCompetencias);
        $agrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });
        foreach ($agrouped as $key => $datavalue) {
            $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }
        $this->dataBrecha=$arraydataBrecha;
        $this->dataCategoria=$arrayCategoria;;
        $this->dataSerie=$arraydataSerie;

        //creamos la data categoria y la seria para la brecha y cumplimiento
        $this->dataCategoriaBrecha=$arrayCategoriaBrecha;
        $this->dataSerieBrecha=$arraydataSerieBrecha;
    }

    /**
    * Generamos la data individual de la evaluacion obtenida por cada competencia
    */
    private function crearData()
    {
       // $competencias = $this->dataCompetencias($this->evaluado_id);

        $dataEvaluacion = new $this->objDataEvaluacion($this->evaluado_id);
        $competencias = $dataEvaluacion->getDataEvaluacion();
        $arrayEvaluador =[];$arrayNivel=[];$arrayEvaluacion=[];

        //Cuando no recibimos ningun record con datos de la evaluacion anulados el record
        if ($competencias->count()==0){
            $this->dataMeta=[];
            $this->dataBrecha=[];
            $this->dataCategoria=[];
            $this->dataSerie=[];
            return [];
        }

        $arrayDataSerie=[];$arrayDataMeta=[];
        foreach ($competencias as $key => $value) {
            $arrayCompetencias[]=$value['competencia'];
            $arrayNivel[]=(int) $value['nivelRequerido'];
            $arrayEvaluacion[]=$value['eva360'];

            //Creamos una array con la data de los evaluadores
            foreach ($value['data'] as $item) {
                $arrayEvaluador[] =['name'=> $item['name'],'average'=>$item['average']];
            }
            //Creamos los datos de las competencias con resultado para la serie individual
            $arrayDataSerie[] =['name'=> $value['competencia'],'eva360'=>$value['eva360'],'nivel'=>$value['nivelRequerido']];
            //Creamos los datos de las competencias con su margen para la serie meta
            $arrayDataMeta[] =['name'=> $value['competencia'],'data'=>$value['nivelRequerido']];
        }

        $datacollection= collect($arrayEvaluador);
        //Agrupamos la data de evaluadores para obtener una coleccion
        $evagrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['average']];
        });

        //Buscamos el evaluado
        $evaluado = Evaluado::find($this->evaluado_id);

        $this->dataMeta=$arrayDataMeta;
        $this->dataSerie=$arrayDataSerie;
        $this->dataCategoria=$evaluado->name;

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

    /**Data Meta */
    public function getDataMeta(){
        return $this->dataMeta;
    }

   /**Data Brecha */
   public function getDataBrecha(){
    return $this->dataBrecha;
   }

   /**Data Serie Brecha */
   public function getDataSerieBrecha(){
    return $this->dataSerieBrecha;
   }

    /**Data de la categoria brecha*/
    public function getDataCategoriaBrecha(){
        return $this->dataCategoriaBrecha;
    }

}
