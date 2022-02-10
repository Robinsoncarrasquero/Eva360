<?php
namespace app\CustomClass;

use App\Evaluado;
use Illuminate\Support\Facades\DB;

class DataObjetivo{
    private $evaluado_id;
    private $dataCruda;

    function __construct($evaluado_id) {
        $this->evaluado_id = $evaluado_id;
    }

    /**
     * Genera la data de la evaluacion con los resultados y los devuelve en una coleccion obtenida con querybuilder
     *
    **/
    public function getDataEvaluacion(){

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($this->evaluado_id)->evaluadores;

        $whereIn=$evaluadores->pluck('id');
        $competencias = DB::table('objetivos')
        ->join('evaluadores', 'objetivos.evaluador_id', '=', 'evaluadores.id')
        ->join('metas', 'objetivos.meta_id', '=', 'metas.id')
        ->join('evaluados', 'evaluadores.evaluado_id', '=', 'evaluados.id')
        ->select('metas.name','evaluadores.relation','metas.nivelrequerido','evaluados.status',
         DB::raw('AVG(resultado) as average,count(relation) as numevaluadores'))
        ->whereIn('evaluador_id',$whereIn)
        ->groupBy('metas.name','relation','metas.nivelrequerido','evaluados.status')
        ->having('evaluados.status','>',1)
       ->orderByRaw('metas.name')
        ->get();

        //Recibimos un objeto sdtClass y lo convertimos a un arreglo manipulable
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
                'nivelRequerido'=>$nivelRequerido,'data'=>$evaluador,
                'cumplido'=>($sumaAverage/$value->count() >= $nivelRequerido ? 'Cumplido' : 'No Cumplido'),
            ];


        }
        $this->dataCruda=$adata;
        return collect($adata);
    }

    /**Obtenemos los datos de la evaluacion en un array asociativo */
    public function getDataCruda(){
        return $this->dataCruda;
    }


}
