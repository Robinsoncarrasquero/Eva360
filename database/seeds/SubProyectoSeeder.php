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
            'proyectos_id'=>1,
         ]);

         //Sub Proyecto 2
        $subproyecto=factory(SubProyecto::class)->create([
            'name'=>'Sub Proyecto Analistas',
            'proyectos_id'=>1,
         ]);
    }
}
