<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ProyectoSeeder::class);
        $this->call(SubProyectoSeeder::class);
        $this->call(NivelCargoSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EvaluadoSeeder::class);
        $this->call(TipoSeeder::class);
        $this->call(CompetenciaSeeder::class);
        $this->call(FrecuenciaSeeder::class);
        $this->call(EvaluacionSeeder::class);
        $this->call(ModeloSeeder::class);

    }
}
