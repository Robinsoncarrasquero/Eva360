<?php

use App\Relation;
use Illuminate\Database\Seeder;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
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
