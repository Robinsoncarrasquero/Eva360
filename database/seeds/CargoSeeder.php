<?php

use Illuminate\Database\Seeder;
use App\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Cargo
        $cargo=factory(Cargo::class)->create([
            'name'=>'Gerente',
            'nivel_cargo_id'=>1,
        ]);

        $cargo=factory(Cargo::class)->create([
            'name'=>'Coordinador',
            'nivel_cargo_id'=>2,
        ]);

        $cargo=factory(Cargo::class)->create([
            'name'=>'Analista',
            'nivel_cargo_id'=>3,
        ]);

        $cargo=factory(Cargo::class)->create([
            'name'=>'Operador',
            'nivel_cargo_id'=>3,
        ]);

        $cargo=factory(Cargo::class)->create([
            'name'=>'Cajero',
            'nivel_cargo_id'=>3,
        ]);

        $cargo=factory(Cargo::class)->create([
            'name'=>'Atencion al Cliente',
            'nivel_cargo_id'=>3,
        ]);

    }
}
