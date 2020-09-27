<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Evaluacion;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('evaluaciones')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //Evaluado 1 Gerente
        $this->add_evaluacion_supervisor(1);
        $this->add_evaluacion_supervisor(2);

        //Evaluado 2 Analista
        $this->add_evaluacion_general(3);
        $this->add_evaluacion_general(4);

        //Evaluado 1 Analista
        $this->add_evaluacion_general(5);
        $this->add_evaluacion_general(6);

    }

    public function add_evaluacion_supervisor($evaluador){

        //Creamos una evaluacion
        $eva1 = factory(Evaluacion::class)->create([
            'competencia_id' => 1,
            'evaluador_id'=>$evaluador,
            'grado'=>'A',
            'ponderacion'=>100,
            'frecuencia'=>100,
            'resultado'=>100,
        ]);

        $eva2 = factory(Evaluacion::class)->create([
            'competencia_id' => 2,
            'evaluador_id'=>$evaluador,
            'grado'=>'B',
            'ponderacion'=>75,
            'frecuencia'=>100,
            'resultado'=>75,
        ]);

        $eva3 = factory(Evaluacion::class)->create([
            'competencia_id' => 4,
            'evaluador_id'=>$evaluador,
            'grado'=>'B',
            'ponderacion'=>75,
            'frecuencia'=>100,
            'resultado'=>75,
        ]);

        $eva4 = factory(Evaluacion::class)->create([
            'competencia_id' => 5,
            'evaluador_id'=>$evaluador,
            'grado'=>'A',
            'ponderacion'=>100,
            'frecuencia'=>50,
            'resultado'=>50,
        ]);
    }

    public function add_evaluacion_general($evaluador){

        //Creamos una evaluacion
        $eva1 = factory(Evaluacion::class)->create([
            'competencia_id' => 1,
            'evaluador_id'=>$evaluador,
            'grado'=>'A',
            'ponderacion'=>100,
            'frecuencia'=>100,
            'resultado'=>100,
        ]);

        $eva2 = factory(Evaluacion::class)->create([
            'competencia_id' => 2,
            'evaluador_id'=>$evaluador,
            'grado'=>'B',
            'ponderacion'=>75,
            'frecuencia'=>100,
            'resultado'=>75,
        ]);

        $eva3 = factory(Evaluacion::class)->create([
            'competencia_id' => 3,
            'evaluador_id'=>$evaluador,
            'grado'=>'B',
            'ponderacion'=>75,
            'frecuencia'=>100,
            'resultado'=>75,
        ]);

        $eva4 = factory(Evaluacion::class)->create([
            'competencia_id' => 4,
            'evaluador_id'=>$evaluador,
            'grado'=>'A',
            'ponderacion'=>100,
            'frecuencia'=>50,
            'resultado'=>50,
        ]);
    }
}
