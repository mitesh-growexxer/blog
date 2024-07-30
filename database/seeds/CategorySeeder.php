<?php

use Illuminate\Database\Seeder;
use App\Category;
use Illuminate\Support\Facades\DB;

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
        DB::table('categories')->insert([
            'name' => 'Electronics',
        ]);
        DB::table('categories')->insert([
            'name' => 'Furniture',
        ]);
        DB::table('categories')->insert([
            'name' => 'Beauty',
        ]);
    }
}
