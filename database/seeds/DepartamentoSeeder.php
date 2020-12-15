<?php

use App\Departamento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('departamentos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS
        //Departamento
        $dpto=factory(Departamento::class)->create([
            'name'=>'Presidencia',
            'description'=>'Presidencia',
        ]);

        $dpto=factory(Departamento::class)->create([
            'name'=>'Administraccion',
            'description'=>'Administracion',
        ]);


        $dpto=factory(Departamento::class)->create([
            'name'=>'Finanzas',
            'description'=>'Finanzas',
        ]);

        $dpto=factory(Departamento::class)->create([
            'name'=>'Recursos Humanos',
            'description'=>'Recursos Humanos',
        ]);

        $dpto=factory(Departamento::class)->create([
            'name'=>'Informatica',
            'description'=>'Informatica',
        ]);

    }
}
