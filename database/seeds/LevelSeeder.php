<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('levels')->insert([
            [
                'name' => 'Beginner',
            ],[
                'name' => 'High Beginner',
            ],[
                'name' => 'Low Intermediate',
            ],[
                'name' => 'Intermediate',
            ],[
                'name' => 'High Intermediate',
            ],[
                'name' => 'Low Advanced',
            ],[
                'name' => 'Advanced',
            ],
        ]);
    }
}
