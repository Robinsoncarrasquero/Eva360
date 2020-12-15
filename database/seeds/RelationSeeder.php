<?php

use App\Relation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('relations')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //Relacion
        $dpto=factory(Relation::class)->create([
            'relation'=>'Manager',
        ]);

        //Relacion
        $dpto=factory(Relation::class)->create([
            'relation'=>'Supervisor',
        ]);

        $dpto=factory(Relation::class)->create([
            'relation'=>'Par',
        ]);

        $dpto=factory(Relation::class)->create([
            'relation'=>'Subordinado',
        ]);

        $dpto=factory(Relation::class)->create([
            'relation'=>'Autoevaluacion',
        ]);

    }
}
