<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataPersonal{
    private $dataSerie;
    private $dataCategoria;
    private $evaluados ;
    private $objDataEvaluacion;
    private $dataMeta;
    private $dataBrecha;
    private $dataSerieBrecha;
    private $dataCategoriaBrecha;
    private $dataBrechaxCompetencia;
    private $dataCategoriaSinModelo;
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
        //$arrayCategoria[]='Modelo';
        $arrayCategoria=[];
        $arrayCategoriaSinModelo=[];

        $dataMeta= $this->getDataMeta();

        $arrayCompetencias=[];
        $arrayPromedio=[];
        $arrayPromedioModelo=[];
        $_arrayBrechaxCompetencia=[];
        foreach ($dataMeta as $item) {
            //arrayCompetencias crear competencias del modelo
            //$arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['data']];
            $arrayPromedio []=['name'=> $item['name'],'data'=>$item['data']];
            //$_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['data']];

        }
        //Promedio de las competencias del Modelo

        $arrayPromedioModelo[]=['name'=> 'Promedio','data'=>collect($arrayPromedio)->avg('data')];

        $arraySerieBrecha=[];
        $arrayCategoriaBrecha=[];
        $nr=0;
        foreach ($data as $key => $value) {
            $arrayCategoria[]=$value['categoria']; //El nombre del evaluado es la categoria
            $arrayCategoriaSinModelo[]=$value['categoria']; //El nombre del evaluado es la categoria
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
            $arrayPromedio=[];
            $arrayEfectivo=[];
            $arrayNivelModelo=[];

            foreach ($value['data'] as $item) {
                $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['eva360']];

                $arrayPotencial[] =['name'=> $item['name'],'data'=>$item['eva360']];

                //Promedio del Modelo
                $arrayPromedio[]=['name'=>$value['categoria'],'data'=>$item['eva360']];

                //Cumplimiento
                $arrayCumplimiento[] =['name'=> $item['name'],'data'=>$item['eva360']];

                $arrayNivelModelo[] =['name'=> $item['name'],'data'=>$item['nivel']];
                /**
                 * Cuando el resultado es menos que nivel requerido se genera una oportunidad de mejora
                 */
                if ($item['eva360']<$item['nivel']){
                    $arraydataOportunidad[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayEfectivo[] =['name'=> $item['name'],'data'=>$item['eva360']];
                    $diferenciador= ($item['eva360']/$item['nivel']*100);
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>($item['eva360']/$item['nivel']*100)-100];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=> $diferenciador];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['nivel']];

                }else{
                    $arraydataFortaleza[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayEfectivo[] =['name'=> $item['name'],'data'=>$item['nivel']];
                    $diferenciador= ($item['eva360']/$item['nivel']*100);
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>0];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$diferenciador];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['nivel']];
                }

            }

            $arrayPromedioModelo[]=['name'=> 'Promedio','data'=>collect($arrayPromedio)->avg('data')];
            $nr++;
            {
                $brecha=0;$cumplimiento=0;$potencial=0;

               // $cumplimiento=collect($arrayCumplimiento)->avg('data');
                $cumplido=collect($arrayEfectivo)->sum('data');
                $modelo=collect($arrayNivelModelo)->sum('data');
                $cumplimiento= $cumplido / $modelo *100;
                 if ($cumplimiento >100){
                    $cumplimiento = 100; $brecha=0;
                }else{
                    $brecha= 100 - $cumplimiento;
                }
                $diferenciador=100-$brecha;

                if (collect($arrayNivelModelo)->avg('data')>0){
                    $potencial=collect($arrayPotencial)->avg('data')/collect($arrayNivelModelo)->avg('data')*100;
                }else{
                    $potencial=0;
                }
                $potencial= $potencial > 100 ? $potencial-100 : 0;

                $arraydataBrecha[]=
                [
                    'categoria'=>$value['categoria'],
                    'cumplimiento'=>$cumplimiento,
                    'brecha'=>$brecha,
                    //'diferenciador'=>$diferenciador,
                    'potencial'=>$potencial,
                    'dataoportunidad'=>$arraydataOportunidad,
                    'datafortaleza'=>$arraydataFortaleza,
                ];
                // if ($this->evaluado_id=86){
                //     dd($dataMeta,$arraydataBrecha);
                // }
                //Creamos la categoria para el cumplimiento y la brecha
                $arrayCategoriaBrecha[]=[$value['categoria']];
                $arraySerieCumplimiento[]=[$cumplimiento];
                $arraySerieBrecha[]=[$brecha];
                $arraySeriePotencial[]=[$potencial];
                $arraySerieDiferenciador[]=[$diferenciador];


            }

        }

        //Generar la data serie del cumpliento y la brecha
        $arraydataSerieBrecha[]=['name'=>'Cumplimiento ','data'=>$arraySerieCumplimiento];
        $arraydataSerieBrecha[]=['name'=>'Brecha','data'=>$arraySerieBrecha];
       // $arraydataSerieBrecha[]=['name'=>'Diferenciador','data'=>$arraySerieDiferenciador];
        $arraydataSerieBrecha[]=['name'=>'Potencial','data'=>$arraySeriePotencial];

        //Generamos una colleccion para agrupar la data de la serie
        $datacollection=collect($arrayCompetencias);
        $agrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });

        foreach ($agrouped as $key => $datavalue) {
            $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }

        //Tomamos el promedio del modelo y promedio de cada evaluado
        //Generamos una colleccion para agrupar la data de la serie
        $dataPromedioModelocollection=collect($arrayPromedioModelo);

        $agrouped = $dataPromedioModelocollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });
        //Agregamos el promedio en la serie para presentaros en la grafica
        foreach ($agrouped as $key => $datavalue) {
        //    $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }

        //Generamos las brechas de cada evaluado por cada competencia
        //Generamos una colleccion para agrupar la data de la serie
         $datacollection=collect($_arrayBrechaxCompetencia);
         $agrouped = $datacollection->mapToGroups(function ($item, $key) {
             return [$item['name']=>$item['data']];
         });

         foreach ($agrouped as $key => $datavalue) {
             $__arrayBrechaxCompetencia[]=['name'=>$key,'data'=>$datavalue];
         }


        $this->dataBrecha=$arraydataBrecha;
        $this->dataCategoria=$arrayCategoria;;
        $this->dataSerie=$arraydataSerie;
        $this->dataCategoriaSinModelo=$arrayCategoriaSinModelo;

        //creamos la data categoria y la seria para la brecha y cumplimiento
        $this->dataCategoriaBrecha=$arrayCategoriaBrecha;
        $this->dataSerieBrecha=$arraydataSerieBrecha;
        $this->dataBrechaxCompetencia=$__arrayBrechaxCompetencia;
        //dd($__arrayBrechaxCompetencia,$_arrayBrechaxCompetencia);
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

        return ['categoria'=>$evaluado->user->name,'data'=>$arrayDataSerie];
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

    /**Data de la brecha por competencias*/
    public function getDataBrechaPorCompetencia(){
        return $this->dataBrechaxCompetencia;
    }

     /**Data de la categoria */
     public function getDataCategoriaSinModelo(){
        return $this->dataCategoriaSinModelo;
    }


    /**
     * Procesa los resultados individuales de forma masiva
     */
    public function procesarDataConModelo()
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
        $arrayCategoriaSinModelo=[];

        $dataMeta= $this->getDataMeta();

        $arrayCompetencias=[];
        $arrayPromedio=[];
        $arrayPromedioModelo=[];
        $_arrayBrechaxCompetencia=[];
        foreach ($dataMeta as $item) {
            //arrayCompetencias crear competencias del modelo
            $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['data']];
            $arrayPromedio []=['name'=> $item['name'],'data'=>$item['data']];
            //$_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['data']];

        }
        //Promedio de las competencias del Modelo

        $arrayPromedioModelo[]=['name'=> 'Promedio','data'=>collect($arrayPromedio)->avg('data')];

        $arraySerieBrecha=[];
        $arrayCategoriaBrecha=[];
        $nr=0;
        foreach ($data as $key => $value) {
            $arrayCategoria[]=$value['categoria']; //El nombre del evaluado es la categoria
            $arrayCategoriaSinModelo[]=$value['categoria']; //El nombre del evaluado es la categoria
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
            $arrayPromedio=[];
            $arrayEfectivo=[];
            $arrayNivelModelo=[];

            foreach ($value['data'] as $item) {
                $arrayCompetencias[] =['name'=> $item['name'],'data'=>$item['eva360']];

                $arrayPotencial[] =['name'=> $item['name'],'data'=>$item['eva360']];

                //Promedio del Modelo
                $arrayPromedio[]=['name'=>$value['categoria'],'data'=>$item['eva360']];

                //Cumplimiento
                $arrayCumplimiento[] =['name'=> $item['name'],'data'=>$item['eva360']];

                $arrayNivelModelo[] =['name'=> $item['name'],'data'=>$item['nivel']];
                /**
                 * Cuando el resultado es menos que nivel requerido se genera una oportunidad de mejora
                 */
                if ($item['eva360']<$item['nivel']){
                    $arraydataOportunidad[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayEfectivo[] =['name'=> $item['name'],'data'=>$item['eva360']];
                    $diferenciador= ($item['eva360']/$item['nivel']*100);
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>($item['eva360']/$item['nivel']*100)-100];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=> $diferenciador];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['nivel']];

                }else{
                    $arraydataFortaleza[]=['competencia'=> $item['name'],'data'=>$item['eva360']];
                    $arrayEfectivo[] =['name'=> $item['name'],'data'=>$item['nivel']];
                    $diferenciador= ($item['eva360']/$item['nivel']*100);
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>0];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$diferenciador];
                    $_arrayBrechaxCompetencia[] =['name'=> $item['name'],'data'=>$item['nivel']];
                }

            }

            $arrayPromedioModelo[]=['name'=> 'Promedio','data'=>collect($arrayPromedio)->avg('data')];
            $nr++;
            {
                $brecha=0;$cumplimiento=0;$potencial=0;

               // $cumplimiento=collect($arrayCumplimiento)->avg('data');
                $cumplimiento=collect($arrayEfectivo)->avg('data');
                $modelo=collect($arrayNivelModelo)->avg('data');
                $cumplimiento= $cumplimiento / $modelo *100;
                 if ($cumplimiento >100){
                    $cumplimiento = 100; $brecha=0;
                }else{
                    $brecha= 100 - $cumplimiento;
                }
                $diferenciador=100-$brecha;

                if (collect($arrayNivelModelo)->avg('data')>0){
                    $potencial=collect($arrayPotencial)->avg('data')/collect($arrayNivelModelo)->avg('data')*100;
                }else{
                    $potencial=0;
                }
                $potencial= $potencial > 100 ? $potencial-100 : 0;

                $arraydataBrecha[]=
                [
                    'categoria'=>$value['categoria'],
                    'cumplimiento'=>$cumplimiento,
                    'brecha'=>$brecha,
                    //'diferenciador'=>$diferenciador,
                    'potencial'=>$potencial,
                    'dataoportunidad'=>$arraydataOportunidad,
                    'datafortaleza'=>$arraydataFortaleza,
                ];

                //Creamos la categoria para el cumplimiento y la brecha
                $arrayCategoriaBrecha[]=[$value['categoria']];
                $arraySerieCumplimiento[]=[$cumplimiento];
                $arraySerieBrecha[]=[$brecha];
                $arraySeriePotencial[]=[$potencial];
                $arraySerieDiferenciador[]=[$diferenciador];


            }

        }

        //Generar la data serie del cumpliento y la brecha
        $arraydataSerieBrecha[]=['name'=>'Cumplimiento ','data'=>$arraySerieCumplimiento];
        $arraydataSerieBrecha[]=['name'=>'Brecha','data'=>$arraySerieBrecha];
       // $arraydataSerieBrecha[]=['name'=>'Diferenciador','data'=>$arraySerieDiferenciador];
        $arraydataSerieBrecha[]=['name'=>'Potencial','data'=>$arraySeriePotencial];

        //Generamos una colleccion para agrupar la data de la serie
        $datacollection=collect($arrayCompetencias);
        $agrouped = $datacollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });

        foreach ($agrouped as $key => $datavalue) {
            $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }

        //Tomamos el promedio del modelo y promedio de cada evaluado
        //Generamos una colleccion para agrupar la data de la serie
        $dataPromedioModelocollection=collect($arrayPromedioModelo);

        $agrouped = $dataPromedioModelocollection->mapToGroups(function ($item, $key) {
            return [$item['name']=>$item['data']];
        });
        //Agregamos el promedio en la serie para presentaros en la grafica
        foreach ($agrouped as $key => $datavalue) {
        //    $arraydataSerie[]=['name'=>$key,'data'=>$datavalue];
        }

        //Generamos las brechas de cada evaluado por cada competencia
        //Generamos una colleccion para agrupar la data de la serie
         $datacollection=collect($_arrayBrechaxCompetencia);
         $agrouped = $datacollection->mapToGroups(function ($item, $key) {
             return [$item['name']=>$item['data']];
         });

         foreach ($agrouped as $key => $datavalue) {
             $__arrayBrechaxCompetencia[]=['name'=>$key,'data'=>$datavalue];
         }


        $this->dataBrecha=$arraydataBrecha;
        $this->dataCategoria=$arrayCategoria;;
        $this->dataSerie=$arraydataSerie;
        $this->dataCategoriaSinModelo=$arrayCategoriaSinModelo;

        //creamos la data categoria y la seria para la brecha y cumplimiento
        $this->dataCategoriaBrecha=$arrayCategoriaBrecha;
        $this->dataSerieBrecha=$arraydataSerieBrecha;
        $this->dataBrechaxCompetencia=$__arrayBrechaxCompetencia;
        //dd($__arrayBrechaxCompetencia,$_arrayBrechaxCompetencia);
    }

}
