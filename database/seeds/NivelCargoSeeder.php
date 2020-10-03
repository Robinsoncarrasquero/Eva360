<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\NivelCargo;


class NivelCargoSeeder extends Seeder
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

        DB::table('nivel_cargos')->truncate();
        DB::table('cargos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //GENERAL
        $nivel=factory(NivelCargo::class)->create([
            'name'=>'Gerente',
        ]);

        $nivel=factory(NivelCargo::class)->create([
            'name'=>'Coordinador',
        ]);

        $nivel=factory(NivelCargo::class)->create([
            'name'=>'Personal No Supervisorio',
        ]);

    }
}
