<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(TipoSeeder::class);
        $this->call(CompetenciaBaseSeeeder::class);
        $this->call(FrecuenciaSeeder::class);
        $this->call(ModeloSeeder::class);
        $this->call(RelationSeeder::class);
        $this->call(ProyectoSeeder::class);
        $this->call(SubProyectoSeeder::class);
        $this->call(NivelCargoSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(DepartamentoSeeder::class);
        //$this->call(CompetenciaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EvaluadoSeeder::class);
        $this->call(EvaluadorSeeder::class);
        $this->call(EvaluacionSeeder::class);
        $this->call(MetaSeeder::class);
        $this->call(MedidaSeeder::class);
    }

    public function truncate_table($table)
    {
        # code...
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS
        DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS
    }
}
