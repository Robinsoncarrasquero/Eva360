<?php
use App\Evaluado;
use App\Evaluador;
use Faker\Calculator\Ean;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class EvaluadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('evaluados')->truncate();
        DB::table('evaluadores')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //Cargos
        $gerente=1;$coordinador=2;$nosupervisorio=3;
        $cargo=[$gerente,$coordinador,$nosupervisorio];
        $subproyecto=[1,2];
        $i=10;
        for ($i=1; $i <11 ; $i++) {
            $this->add_evaluado($cargo[rand(0,count($cargo)-1)],$subproyecto[rand(0,count($subproyecto)-1)]);
        }


    }

    public function add_evaluado($xcargo,$xsubproyecto)
        {
            //Creamos un evaluado
            $evaluadox = factory(App\Evaluado::class)->create([
                'status'=>2,
                'cargo_id'=>$xcargo,
                'subproyecto_id'=>$xsubproyecto,
            ]);

            $supervisores=factory(Evaluador::class, 2)->create([
                'relation'=>'Supervisores',
                'evaluado_id'=>$evaluadox,
                ]);

            $pares=factory(Evaluador::class, 2)->create([
                'relation'=>'Pares',
                'evaluado_id'=>$evaluadox,
                ]);



        }
}
