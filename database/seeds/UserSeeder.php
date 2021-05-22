<?php

use App\Evaluado;
use App\Evaluador;
use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_admin);
        $this->add_user();

    }
    public function add_user()
    {
        # code...
        //Cargos
        $gerente=1;$coordinador=2;$nosupervisorio=3;
        $cargo=[$gerente,$coordinador,$nosupervisorio];
        $subproyecto=[1,2];
        //Departamentos
        $rrhh=4;$informatica=5;
        $dpto=[1,2,3,4,5];
        $i=1;
        for ($i=1; $i <11 ; $i++) {
            $this->add_user_new($cargo[rand(0,count($cargo)-1)],$subproyecto[rand(0,count($subproyecto)-1)],$dpto[rand(0,count($dpto)-1)]);
        }
    }

    public function add_user_new($xcargo,$xsubproyecto,$xdpto)
    {
        $role_user = Role::where('name', 'user')->first();

        //Creamos un evaluado
        $user = factory(App\User::class)->create([
            'cargo_id'=>$xcargo,
            'departamento_id'=>$xdpto,
            'password' => bcrypt('secret1234'),
        ])->roles()->attach($role_user);

    }
    public function add_user_evaluador()
    {
        $evaluadores = Evaluador::all();
        foreach ($evaluadores as $key => $evaluador) {
            $evaluado = Evaluado::find($evaluador->evaluado_id);
            $role_user = Role::where('name', 'user')->first();
            $user =  new User();
            $user->name = $evaluador->name;
            $user->email = $evaluador->email;
            $user->password = bcrypt('secret1234');
            $user->cargo_id=rand(1,5);
            $user->departamento_id=$evaluado->departamento_id;
            $user->save();
            $user->roles()->attach($role_user);
            $evaluador->user_id=$user->id;
            $evaluador->save();
        }
    }



}
