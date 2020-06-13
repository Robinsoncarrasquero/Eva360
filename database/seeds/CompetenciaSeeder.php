<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Competencia;
use App\Grado;

class CompetenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('Competencias')->truncate();
        DB::table('Grados')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        // $competencia = collect(['G','S', 'E','T']);

        // $comp=$competencia->each(function ($item, $key) {

        //     $comp=factory(App\Competencia::class)->create([
        //         'tipo'=>$item,
        //     ]);


        // });


        //GENERAL
        $competencia=factory(Competencia::class)->create([
            'tipo'=>'G',
            'name'=>'Competencia  Adaptabilidad Flexibilidad',
        ]);

        //Creamos Los grados de la competencias
        $gradoa=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia->id

        ]);
        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia->id

        ]);
        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia->id

        ]);
        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia->id

        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'ponderacion'=>0,
            'competencia_id'=>$competencia->id
        ]);


        //ESPECIFICA
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'G',
            'name'=>'Identificación con la Institución',

        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);


        //TECNICA
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'T',
            'name'=>'Capacidad Tecnica',
        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);


        //SUPERVISOR
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'S',
            'name'=>'Liderazgo',

        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);


        //SUPERVISOR
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'S',
            'name'=>'Orientacion a Resultados',

        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);



        //ESPECIFICA
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'E',
            'name'=>'Iniciativa',

        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);

        //ESPECIFICA
        $competencia1 = factory(App\Competencia::class)->create([
            'tipo'=>'E',
            'name'=>'Desarrollo de otros',

        ]);

        //Creamos Los grados de la competencias
        $gradoA=factory(Grado::class)->create([
            'grado'=>'A',
            'ponderacion'=>100,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradob=factory(Grado::class)->create([
            'grado'=>'B',
            'ponderacion'=>75,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradoc=factory(Grado::class)->create([
            'grado'=>'C',
            'ponderacion'=>50,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'D',
            'ponderacion'=>25,
            'competencia_id'=>$competencia1->id
        ]);

        //Creamos Los grados de la competencias
        $gradod=factory(Grado::class)->create([
            'grado'=>'E',
            'competencia_id'=>$competencia1->id,
            'ponderacion'=>0,

        ]);

    //ESPECIFICA
    $competencia1 = factory(App\Competencia::class)->create([
        'tipo'=>'E',
        'name'=>'Etica e integridad',

    ]);

    //Creamos Los grados de la competencias
    $gradoA=factory(Grado::class)->create([
        'grado'=>'A',
        'ponderacion'=>100,
        'competencia_id'=>$competencia1->id
    ]);

    //Creamos Los grados de la competencias
    $gradob=factory(Grado::class)->create([
        'grado'=>'B',
        'ponderacion'=>75,
        'competencia_id'=>$competencia1->id
    ]);

    //Creamos Los grados de la competencias
    $gradoc=factory(Grado::class)->create([
        'grado'=>'C',
        'ponderacion'=>50,
        'competencia_id'=>$competencia1->id
    ]);

    //Creamos Los grados de la competencias
    $gradod=factory(Grado::class)->create([
        'grado'=>'D',
        'ponderacion'=>25,
        'competencia_id'=>$competencia1->id
    ]);

    //Creamos Los grados de la competencias
    $gradod=factory(Grado::class)->create([
        'grado'=>'E',
        'competencia_id'=>$competencia1->id,
        'ponderacion'=>0,

    ]);




    }
}
