<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); //DESACTIVA EL CHECKEO DE CLAVES FORANEAS

        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); //ACTIVA EL CHECKEO DE CLAVES FORANEAS

        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrator';
        $role->save();

        $role = new Role();
        $role->name = 'user';
        $role->description = 'User';
        $role->save();

    }
}
