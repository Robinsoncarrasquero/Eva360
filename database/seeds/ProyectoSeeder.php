<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 use App\Proyecto;

class ProyectoSeeder extends Seeder
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

        DB::table('subproyectos')->truncate();
        DB::table('proyectos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //Proyecto
        $proyecto=factory(Proyecto::class)->create([
            'name'=>'Proyecto XYZ',
        ]);


    }
}
