<?php
use App\Evaluado;
use App\Evaluador;
use App\Role;
use App\User;
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

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $users = User::select("*")
        ->where("id", ">", 1)
        ->get();
        $subproyecto=[1,2];
        foreach ($users as $key => $user) {
            $evaluado =  new Evaluado();
            $evaluado->name = $user->name;
            $evaluado->subproyecto_id= $subproyecto[rand(0,count($subproyecto)-1)];
            $evaluado->departamento_id = $user->departamento_id;
            $evaluado->cargo_id = $user->cargo_id;
            $evaluado->user_id = $user->id;
            $evaluado->status=2;
            $evaluado->save();
        }


    }

    public function add_evaluado($xcargo,$xsubproyecto,$xdpto)
        {
            //Creamos un evaluado
            $evaluadox = factory(App\Evaluado::class)->create([
                'status'=>2,
                'cargo_id'=>$xcargo,
                'departamento_id'=>$xdpto,
                'subproyecto_id'=>$xsubproyecto,
            ]);

            // $supervisores=factory(Evaluador::class, 2)->create([
            //     'relation'=>'Supervisores',
            //     'evaluado_id'=>$evaluadox,
            //     ]);

            // $this->add_user_evaluador($supervisores,$xdpto);
            // $pares=factory(Evaluador::class, 2)->create([
            //     'relation'=>'Pares',
            //     'evaluado_id'=>$evaluadox,
            //     ]);
            // $this->add_user_evaluador($pares,$xdpto);

    }

}
