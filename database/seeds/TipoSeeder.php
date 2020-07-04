<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
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

        DB::table('tipos')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $tipos = collect(['G'=>'General','S'=>'Supervisor', 'E'=>'Especifica','T'=>'Tecnica']);

        $tipos->each(function ($item, $key) {
            factory(App\Tipo::class)->create([
                'tipo'=>$item,
            ]);

        });


    }


}
