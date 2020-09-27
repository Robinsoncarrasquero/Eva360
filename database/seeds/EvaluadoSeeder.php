<?php
use App\Evaluado;
use App\Evaluador;
use Faker\Calculator\Ean;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class EvaluadoSeeder extends Seeder
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

        DB::table('evaluados')->truncate();
        DB::table('evaluadores')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        //Creamos un evaluado
        $evaluado1 = factory(App\Evaluado::class)->create([
            'name' => 'Mary Doral',
            'cargo'=>'Gerente',
            'status'=>2,
            'subproyectos_id'=>1,
        ]);

        //Cargamos los evaluadores a este evaluado
        $evaluado1->evaluadores()->createMany(
            factory(Evaluador::class, 2)->make()->toArray()
        );

        //Creamos un evaluado
        $evaluado2 = factory(App\Evaluado::class)->create([
            'name' => 'Jonhy Daza',
            'cargo'=>'Analista',
            'status'=>2,
            'subproyectos_id'=>2,
        ]);

        //Cargamos los evaluadores a este evaluado
        $evaluado2->evaluadores()->createMany(
            factory(Evaluador::class, 2)->make()->toArray()
        );

        //Creamos un evaluado
        $evaluado3 = factory(App\Evaluado::class)->create([
            'name' => 'Marlon Brandon',
            'cargo'=>'Analista',
            'status'=>2,
            'subproyectos_id'=>2,
        ]);

        //Cargamos los evaluadores a este evaluado
        $evaluado3->evaluadores()->createMany(
            factory(Evaluador::class, 2)->make()->toArray()
        );

    }
}
