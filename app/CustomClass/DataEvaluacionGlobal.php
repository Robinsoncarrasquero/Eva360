<?php
namespace app\CustomClass;

use App\Configuracion;
use App\Proyecto;
use Illuminate\Support\Facades\DB;

class DataEvaluacionGlobal{
    private $proyecto_id;
    private $dataCruda;
    private $dataOportunidad;
    private $dataFortaleza;
    private $dataOportunidadFortaleza;

    function __construct($proyecto_id) {
        $this->proyecto_id = $proyecto_id;
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

    /**
     * Genera la data de la evaluacion por nivel de cargo con los resultados y los devuelve en una coleccion
     *
    **/
    public function getDataEvaluacionNivel(){

        //Obtenemos la configuracion particular
        $configuraciones = Configuracion::first();
        if ($configuraciones->promediarautoevaluacion){
            $autoevaluacion=' ';
        }else {
            $autoevaluacion='Autoevaluacion';
        }
        //Buscamos los evaluadores del evaluado
        $proyecto = Proyecto::find($this->proyecto_id);
        $whereIn=$proyecto->id;

        $competencias = DB::table('evaluaciones')
        ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
        ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
        ->join('evaluados', 'evaluadores.evaluado_id', '=', 'evaluados.id')
        ->join('cargos', 'evaluados.cargo_id', '=', 'cargos.id')
        ->join('nivel_cargos', 'cargos.nivel_cargo_id', '=', 'nivel_cargos.id')
        ->join('subproyectos', 'evaluados.subproyecto_id', '=', 'subproyectos.id')
        ->join('proyectos', 'subproyectos.proyecto_id', '=', 'proyectos.id')
        ->select('nivel_cargos.name as nivelcargo','competencias.name','evaluaciones.nivelrequerido',
        'evaluados.status',
        DB::raw('AVG(resultado) as average,count(evaluaciones.resultado) as records'))
        ->where([['proyectos.id','=',$whereIn],['evaluadores.relation','<>',$autoevaluacion]])
        ->groupBy('nivel_cargos.name','competencias.name','evaluaciones.nivelrequerido','evaluados.status')
        ->having('evaluados.status','=',2)
        //->orderByRaw('nivel_cargos.name','cccompetencias.name')
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
            $recordx=[];
            $recordm=[];

            foreach ($value as $item) {
                $competencia=$item[0];
                $record[] = ['competencia'=>$item[0],'average'=>$item[1],'records'=>$item[2],'nivel'=>$item[3]];
               // $this->add_fortaleza_oportunidad($competencia,$item[1],$item[3]);
            }

            $collection= collect($record);

             //Agrupamos la coleccion por nombre de competencia
            $groupdatar = $collection->mapToGroups(function ($item, $key) {
                return [$item['competencia'] => [$item['average'],$item['records'],$item['nivel']]];
            });

            foreach ($groupdatar as $agrupacompetencias=> $valued) {

                $datax=[];
                foreach ($valued as $item) {
                    $datax[] = ['average'=>$item[0],'records'=>$item[1],'nivel'=>$item[2]];
                }

                $resultado=collect($datax)->avg('average');

                $nivel=$datax[0]['nivel'];
                $recordx[] = ['competencia'=>$agrupacompetencias,'average'=>$resultado,'grupos'=>count($datax),'nivel'=>$nivel];
                $recordm[] = ['competencia'=>$agrupacompetencias,'average'=>$nivel,'grupos'=>count($datax),'nivel'=>$nivel];

                $this->add_fortaleza_oportunidad($agrupacompetencias,$resultado,$nivel);
            }

            $data_join=collect($this->join_fortaleza_oportunidad($agrupa));
            $adata[]=['nivel'=>$agrupa,'data'=>$recordx];
            //$adata[]=['nivel'=>$agrupa.' Modelo','data'=>$recordm];
        }

        $this->dataCruda=$adata;
        return collect($adata);
    }

    /**
     * Genera la data de la evaluacion por tipo con los resultados y los devuelve en una coleccion
     *
    **/

    public function getDataEvaluacionTipo(){

        //Obtenemos la configuracion particular
        $configuraciones = Configuracion::first();
        if ($configuraciones->promediarautoevaluacion){
            $autoevaluacion=' ';
        }else {
            $autoevaluacion='Autoevaluacion';
        }

       //Buscamos los evaluadores del evaluado
       $proyecto = Proyecto::find($this->proyecto_id);
       $whereIn=$proyecto->id;
       $competencias = DB::table('evaluaciones')
       ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
       ->join('tipos', 'competencias.tipo_id', '=', 'tipos.id')
       ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
       ->join('evaluados', function ($join) {
           $join->on('evaluadores.evaluado_id', '=', 'evaluados.id')
                ->where('evaluados.status', '=', 2);
       })
       ->join('subproyectos', 'evaluados.subproyecto_id', '=', 'subproyectos.id')
       ->join('proyectos', 'subproyectos.proyecto_id', '=', 'proyectos.id')
       ->select(DB::raw('count(evaluados.id) as records,tipos.tipo,
       competencias.name,evaluaciones.nivelrequerido'), DB::raw('AVG(evaluaciones.resultado) as average'))
       ->where([['proyectos.id',$whereIn],['evaluadores.relation','<>',$autoevaluacion]])
       ->groupBy('tipos.tipo','competencias.name','evaluaciones.nivelrequerido','evaluados.status')
       ->having('evaluados.status','=',2)
       ->orderByRaw('tipos.tipo,competencias.name,evaluaciones.nivelrequerido')
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

       foreach ($grouped as $agrupa => $value) {

           $record=[];
           $recordx=[];
           $recordm=[];
           foreach ($value as $item) {
                $competencia=$item[0];
                $record[] = ['competencia'=>$item[0],'average'=>$item[1],'records'=>$item[2],'nivel'=>$item[3]];
                // $this->add_fortaleza_oportunidad($competencia,$item[1],$item[3]);
            }

           $collection= collect($record);


          //Agrupamos la coleccion por nombre de competencia
          $groupdatar = $collection->mapToGroups(function ($item, $key) {
              return [$item['competencia'] => [$item['average'],$item['records'],$item['nivel']]];
          });
          foreach ($groupdatar as $agrupacompetencias=> $valued) {

              $datax=[];
              foreach ($valued as $item) {
                  $datax[] = ['average'=>$item[0],'records'=>$item[1],'nivel'=>$item[2]];
              }
              $resultado=collect($datax)->avg('average');
              $nivel=$datax[0]['nivel'];
              $recordx[] = ['competencia'=>$agrupacompetencias,'average'=>$resultado,'grupos'=>count($datax),'nivel'=>$nivel];
              $recordm[] = ['competencia'=>$agrupacompetencias,'average'=>$nivel,'grupos'=>count($datax),'nivel'=>$nivel];
              $this->add_fortaleza_oportunidad($agrupacompetencias,$resultado,$nivel);
            }

           $this->join_fortaleza_oportunidad($agrupa);
           $adata[]=['tipo'=>$agrupa,'data'=>$recordx];
           //$adata[]=['tipo'=>$agrupa.' Modelo','data'=>$recordm];


       }


       $this->dataCruda=$adata;
       return collect($adata);
   }


}
