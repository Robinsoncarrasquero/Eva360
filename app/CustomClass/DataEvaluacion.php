<?php
namespace app\CustomClass;

use App\Configuracion;
use App\Evaluado;
use App\Qualify;
use ConfigSingleton;
use Illuminate\Support\Facades\DB;

class DataEvaluacion{
    private $evaluado_id;
    private $dataCruda;
    private $configuraciones =null;
    private $calificaciones = null;

    function __construct($evaluado_id) {
        $this->evaluado_id = $evaluado_id;

        //Obtenemos la configuracion singleton
        $this->configuraciones = ConfigSingleton::getInstance()->data();
        $this->calificaciones = Qualify::orderBy('nivel','ASC')->get();

    }

    /**
     * Genera la data de la evaluacion con los resultados y los devuelve en una coleccion obtenida con querybuilder
     *
    **/
    public function getDataEvaluacion(){

        //Obtenemos la calificaciones
        $calificaciones = $this->calificaciones;

        //Obtenemos la configuracion particular singleton del constructor
        $configuraciones = $this->configuraciones;

        //Buscamos los evaluadores del evaluado
        $evaluadores = Evaluado::find($this->evaluado_id)->evaluadores;

        $whereIn=$evaluadores->pluck('id');

        $competencias = DB::table('evaluaciones')
        ->join('evaluadores', 'evaluaciones.evaluador_id', '=', 'evaluadores.id')
        ->join('competencias', 'evaluaciones.competencia_id', '=', 'competencias.id')
        ->join('evaluados', 'evaluadores.evaluado_id', '=', 'evaluados.id')
        ->select('competencias.name','evaluadores.relation','evaluaciones.nivelrequerido','evaluados.status',
         DB::raw('AVG(resultado) as average,count(relation) as numevaluadores'))
        ->whereIn('evaluador_id',$whereIn)
        ->groupBy('competencias.name','relation','evaluaciones.nivelrequerido','evaluados.status')
        ->having('evaluados.status','>',1)
       ->orderByRaw('competencias.name')
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
            $contador=0;
            foreach ($value as $item) {

                $evaluador[] = ['name'=>$item[1],'average'=>$item[0]];

                if ($configuraciones->promediarautoevaluacion){
                    $sumaAverage += $item[0];
                    $contador ++;
                }elseif ($item[1]!='Autoevaluacion'){
                    $sumaAverage += $item[0];
                    $contador ++;
                }
                $nivelRequerido=$item[2];
            }
            $calificado='Nothing';
            $colorcalificacion='#b020a4';
            foreach ($calificaciones as $calificacion) {
                if ($sumaAverage/$contador >= $calificacion['nivel']){
                    $calificado=$calificacion['name'];
                    $colorcalificacion=$calificacion['color'];
                }
            }
            $resultado =$sumaAverage/$contador;
            $brecha = ($resultado < $nivelRequerido ?  ($resultado / $nivelRequerido * 100) - 100 : 0);
            $adata[]=
            [
                'competencia'=>$key,'eva360'=>$sumaAverage/$contador,
                'nivelRequerido'=>$nivelRequerido,'data'=>$evaluador,
                'calificacion'=>$calificado,
                'colorcalificacion'=>$colorcalificacion,
                'cumplido'=>($resultado >= $nivelRequerido ? 'Cumplido' : 'No Cumplido'),
                'brecha' => $brecha,
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
