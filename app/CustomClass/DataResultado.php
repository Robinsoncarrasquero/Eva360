<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataResultado{

    private $evaluado_id;
    private $dataSerie;
    private $dataCategoria;
    private $dataCompetencias;

    function __construct($evaluado_id)
    {
        $this->evaluado_id=$evaluado_id;
    }

    /**Generamos la data */
    public function crearGrafica()
    {

        $competencias = $this->dataCompetencias($this->evaluado_id);

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
        //filtramos para un solo grupo de evaluadores
        // $relation='Boss';
        // $filtro = $evagrouped->reject(function ($item, $key) use ($relation){
        //     return  $key!=$relation ;
        // });

        //Creamos un array con la data de cada serie
        $dataSerie=[];
        $dataSerie[]= ['name'=>'Nivel Requerido','data'=>$arrayNivel];

        foreach ($evagrouped as $key => $value) {
            $data=$value;
            $dataSerie[]=['name'=>$key,'data'=>$data];
            $datax[]=['name'=>$key,'data'=>$data];
        }

        $dataSerie[]= ['name'=>'Vision360','data'=>$arrayEvaluacion];
        $dataCategoria=$arrayCategoria;
        $this->dataCategoria=$dataCategoria;
        $this->dataSerie=$dataSerie;
    }

    /*Construimos la data via querybuilder*/
    public function dataCompetencias(){

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($this->evaluado_id)->evaluadores;

        $whereIn=$evaluadores->pluck('id');

        $competencias = DB::table('evaluaciones')
        ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
        ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
        ->select('competencias.name','evaluadores.relation','competencias.nivelrequerido',
         DB::raw('AVG(resultado) as average'))
        ->whereIn('evaluador_id',$whereIn)
        ->groupBy('competencias.name','relation','competencias.nivelrequerido')
        ->orderByRaw('competencias.name')
        ->get();

        //recibimos un objeto sdtClass y lo convertimos a un arreglo manipulable
        $dataArray = json_decode(json_encode($competencias), true);
        $collection= collect($dataArray);
        //Agrupamos la coleccion por nombre de competencia
        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['name'] => [$item['average'],$item['relation'],$item['nivelrequerido']]];
        });

        //Creamos un arreglo desde la coleccion agrupada para reorganizar la informacion por competencia
        $adata=[];
        foreach ($grouped as $key => $value) {

            $sumaAverage=0;
            $evaluador=[];
            $nivelRequerido=0;

            foreach ($value as $item) {
                $evaluador[] = ['name'=>$item[1],'average'=>$item[0]];
                $sumaAverage += $item[0];
                $nivelRequerido=$item[2];
            }
            $adata[]=
            [
                'competencia'=>$key,'eva360'=>$sumaAverage/$value->count(),
                'nivelRequerido'=>$nivelRequerido,'data'=>$evaluador
            ];

        }
        $this->dataCompetencias=$adata;
        return collect($adata);
    }

    /**Data de la serie */
    public function getDataSerie(){

        return $this->dataSerie;
    }
    /**Data de la categoria */
    public function getDataCategoria(){
        return $this->dataCategoria;
    }

    /**Data de Competencias */
    public function getCompetencias(){
        return $this->dataCompetencias;
    }

}
