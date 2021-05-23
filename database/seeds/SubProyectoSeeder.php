<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\SubProyecto;

class SubProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Sub Proyecto 1
        $subproyecto=factory(SubProyecto::class)->create([
            'name'=>'Sub Proyecto Gerentes',
            'proyecto_id'=>1,
         ]);

         //Sub Proyecto 2
        $subproyecto=factory(SubProyecto::class)->create([
            'name'=>'Sub Proyecto Analistas',
            'proyecto_id'=>1,
         ]);

        //Sub Proyecto 1
        $subproyecto=factory(SubProyecto::class)->create([
            'name'=>'Administracion Vendedor',
            'proyecto_id'=>2,
         ]);

        //Sub Proyecto 2
        $subproyecto=factory(SubProyecto::class)->create([
            'name'=>'Administracion Analista',
            'proyecto_id'=>2,
         ]);
    }
}
