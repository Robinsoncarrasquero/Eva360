<?php

use App\Evaluado;
use App\Evaluador;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluadorSeeder extends Seeder
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

        DB::table('evaluadores')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $role_user = Role::where('name', 'user')->first();

        $gerente=1;$coordinador=2;$nosupervisorio=3;
        $cargo=[$gerente,$coordinador,$nosupervisorio];
        $rrhh=4;$informatica=5;
        $dpto=[1,2,3,4,5];
        $evaluados= Evaluado::all();

        foreach ($evaluados as $key => $evaluado) {

            $user1 = factory(User::class)->create([
                'cargo_id'=>$cargo[rand(0,count($cargo)-1)],
                'departamento_id'=>$evaluado->departamento_id,
                'password' => bcrypt('secret'),
            ]);


            $super1=factory(Evaluador::class)->create([
                'relation'=>'Supervisor',
                'evaluado_id'=>$evaluado,
                'user_id'=>$user1,
                'email'=>$user1->email,
                'name'=>$user1->name,
                'cargo_id'=>$user1->cargo_id,
                'departamento_id'=>$user1->departamento_id,
                'status'=>2,
            ]);

            $user2 = factory(User::class)->create([
                'cargo_id'=>$cargo[rand(0,count($cargo)-1)],
                'departamento_id'=>$evaluado->departamento_id,
                'password' => bcrypt('secret'),
            ]);

            $super2=factory(Evaluador::class)->create([
                'relation'=>'Supervisor',
                'evaluado_id'=>$evaluado,
                'user_id'=>$user2,
                'email'=>$user2->email,
                'name'=>$user2->name,
                'cargo_id'=>$user2->cargo_id,
                'departamento_id'=>$user2->departamento_id,
                'status'=>2,
            ]);

            $user3 = factory(User::class)->create([
                'cargo_id'=>$cargo[rand(0,count($cargo)-1)],
                'departamento_id'=>$evaluado->departamento_id,
                'password' => bcrypt('secret'),
            ]);

            $par1=factory(Evaluador::class)->create([
                'relation'=>'Par',
                'evaluado_id'=>$evaluado,
                'user_id'=>$user3,
                'email'=>$user3->email,
                'name'=>$user3->name,
                'cargo_id'=>$user3->cargo_id,
                'departamento_id'=>$user3->departamento_id,
                'status'=>2,
            ]);

            $user4 = factory(User::class)->create([
                'cargo_id'=>$cargo[rand(0,count($cargo)-1)],
                'departamento_id'=>$evaluado->departamento_id,
                'password' => bcrypt('secret'),
            ]);

            $par2=factory(Evaluador::class)->create([
                'relation'=>'Par',
                'evaluado_id'=>$evaluado,
                'user_id'=>$user4,
                'email'=>$user4->email,
                'name'=>$user4->name,
                'cargo_id'=>$user4->cargo_id,
                'departamento_id'=>$user4->departamento_id,
                'status'=>2,
            ]);

        }
    }



}
