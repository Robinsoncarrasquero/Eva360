<?php

use Illuminate\Database\Seeder;

use App\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $gradob=factory(Category::class,50)->create([

        ]);


    }
}
