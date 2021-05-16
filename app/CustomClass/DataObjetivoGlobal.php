<?php
namespace app\CustomClass;

use App\Proyecto;
use Illuminate\Support\Facades\DB;

class DataObjetivoGlobal{
    private $proyecto_id;
    private $dataCruda;
    private $dataOportunidad;
    private $dataFortaleza;
    private $dataOportunidadFortaleza;

    function __construct($proyecto_id) {
        $this->proyecto_id = $proyecto_id;
    }

    /**
     * Genera la data de la evaluacion por tipo con los resultados y los devuelve en una coleccion
     *
    **/
    public function getDataEvaluacionTipo(){

        //Buscamos los evaluadores del evaluado
        $proyecto = Proyecto::find($this->proyecto_id);
        $whereIn=$proyecto->id;
        $competencias = DB::table('objetivos')
        ->join('metas', 'objetivos.meta_id', '=', 'metas.id')
        ->join('tipos', 'metas.tipo_id', '=', 'tipos.id')
        ->join('evaluadores', 'objetivos.evaluador_id', '=', 'evaluadores.id')
        ->join('evaluados', 'evaluadores.evaluado_id', '=', 'evaluados.id')
        ->join('subproyectos', 'evaluados.subproyecto_id', '=', 'subproyectos.id')
        ->join('proyectos', 'subproyectos.proyecto_id', '=', 'proyectos.id')
        ->select('tipos.tipo','metas.name','metas.nivelrequerido','evaluados.status',
        DB::raw('AVG(resultado) as average,count(objetivos.resultado) as records'))
        ->where('proyectos.id',$whereIn)
        ->groupBy('tipos.tipo','metas.name','metas.nivelrequerido','evaluados.status')
        ->having('evaluados.status','>',1)
        ->orderByRaw('tipos.tipo,metas.name')
        ->get();
        //Recibimos un objeto sdtClass y lo convertimos a un arreglo manipulable
        $dataArray = json_decode(json_encode($competencias), true);
        $collection= collect($dataArray);
        //Agrupamos la coleccion por nombre de competencia
        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['tipo'] => [$item['name'],$item['average'],$item['records'],$item['nivelrequerido']]];
        });

        //Creamos un arreglo desde la coleccion agrupada para reorganizar la informacion por competencia
        $adata=[];
        foreach ($grouped as $tipo => $value) {

            $record=[];
            foreach ($value as $item) {
                $record[] = ['competencia'=>$item[0],'average'=>$item[1],'records'=>$item[2],'nivel'=>$item[3]];
                $competencia=$item[0];

                $this->add_fortaleza_oportunidad($competencia,$item[1],$item[3]);
            }

            $this->join_fortaleza_oportunidad($tipo);
            $adata[]=['tipo'=>$tipo,'data'=>$record];
        }

        $this->dataCruda=$adata;
        return collect($adata);
    }


    /**
     * Genera la data de la evaluacion por nivel de cargo con los resultados y los devuelve en una coleccion
     *
    **/
    public function getDataEvaluacionNivel(){

        //Buscamos los evaluadores del evaluado
        $proyecto = Proyecto::find($this->proyecto_id);
        $whereIn=$proyecto->id;

        $competencias = DB::table('objetivos')
        ->join('metas', 'objetivos.meta_id', '=', 'metas.id')
        ->join('evaluadores', 'objetivos.evaluador_id', '=', 'evaluadores.id')
        ->join('evaluados', 'evaluadores.evaluado_id', '=', 'evaluados.id')
        ->join('cargos', 'evaluados.cargo_id', '=', 'cargos.id')
        ->join('nivel_cargos', 'cargos.nivel_cargo_id', '=', 'nivel_cargos.id')
        ->join('subproyectos', 'evaluados.subproyecto_id', '=', 'subproyectos.id')
        ->join('proyectos', 'subproyectos.proyecto_id', '=', 'proyectos.id')
        ->select('nivel_cargos.name as nivelcargo','metas.name','metas.nivelrequerido','evaluados.status',
        DB::raw('AVG(resultado) as average,count(objetivos.resultado) as records'))
        ->where('proyectos.id',$whereIn)
        ->groupBy('nivel_cargos.name','metas.name','metas.nivelrequerido','evaluados.status')
        ->having('evaluados.status','>',1)
        ->orderByRaw('nivel_cargos.name','metas.name')
        ->get();

        //Recibimos un objeto sdtClass y lo convertimos a un arreglo manipulable
        $dataArray = json_decode(json_encode($competencias), true);
        $collection= collect($dataArray);
        //Agrupamos la coleccion por nombre de competencia
        $grouped = $collection->mapToGroups(function ($item, $key) {
            return [$item['nivelcargo'] => [$item['name'],$item['average'],$item['records'],$item['nivelrequerido']]];
        });

        //Creamos un arreglo desde la coleccion agrupada para reorganizar la informacion por competencia
        $adata=[];
        foreach ($grouped as $agrupa=> $value) {

            $record=[];

            foreach ($value as $item) {
                $competencia=$item[0];
                $record[] = ['competencia'=>$item[0],'average'=>$item[1],'records'=>$item[2],'nivel'=>$item[3]];

                $this->add_fortaleza_oportunidad($competencia,$item[1],$item[3]);
            }

            $data_join=collect($this->join_fortaleza_oportunidad($agrupa));
            $adata[]=['nivel'=>$agrupa,'data'=>$record];
       }
       //dd($adata,$join_fortaleza_oportunidad);
        $this->dataCruda=$adata;
        return collect($adata);
    }

    /** Fortaleza y Oportunidades */
    private function add_fortaleza_oportunidad($competencia,$resultado,$margen){

        //Cuando el average es menor al nivel requerido surge una
        //oportunidad de mejora en otro caso surge una fortaleza

        if ($resultado<$margen){
            $this->dataOportunidad[]=['competencia'=> $competencia,'nivel'=>$margen,'resultado'=>$resultado];
        }

        if ($resultado>=$margen){
            $this->dataFortaleza[]=['competencia'=> $competencia,'nivel'=>$margen,'resultado'=>$resultado];
        }
    }

    /** Join de Fortaleza y Oportunidades */
    private function join_fortaleza_oportunidad($agrupa){

        //Cuando el average es menor al nivel requerido surge una
        //oportunidad de mejora en otro caso surge una fortaleza

         $this->dataOportunidadFortaleza[]=['agrupa'=>$agrupa,'datafortaleza'=>$this->dataFortaleza,'dataoportunidad'=>$this->dataOportunidad];
         $this->dataFortaleza=[];$this->dataOportunidad=[];
         return $this->dataOportunidadFortaleza;
     }

    /**Obtenemos los datos de la evaluacion en un array asociativo */
    public function getDataCruda(){
        return $this->dataCruda;
    }

    /**Obtenemos los datos de Fortalezas y Oportunidades */
    public function getDataFortalezaOptunidad(){
        return $this->dataOportunidadFortaleza;
    }


}
