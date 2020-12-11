<?php

use App\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
