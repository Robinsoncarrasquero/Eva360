<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetasSeeder extends Seeder
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

        DB::table('metas')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $competencia=factory(Meta::class)->create([
            'name'=>'Ventas cobradas',
            'tipo_id'=>1,
            'nivelrequerido'=>75,
            'description'=>'Ventas cobradas a los clientes.',
        ]);

        //Creamos la submeta
        factory(SubMeta ::class)->create([
            'submeta'=>'1',
            'requerido'=>100,
            'meta_id'=>$competencia->id,
            'description'=>'Monto de las ventas cobradas',
        ]);
    }
}
