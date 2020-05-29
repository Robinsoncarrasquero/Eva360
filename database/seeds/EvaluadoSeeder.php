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

        $evaluado = factory(App\Evaluado::class)->create([
            'name' => 'Robinson',
        ]);

        $evaluado->evaluadores()->createMany(
            factory(Evaluador::class, 3)->make()->toArray()
        );




    }
}
