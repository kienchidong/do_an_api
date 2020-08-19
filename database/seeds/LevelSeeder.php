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
                'name' => 'Beginner(0-250)',
            ],[
                'name' => 'High Beginner(255-400)',
            ],[
                'name' => 'Low Intermediate(405-600)',
            ],[
                'name' => 'Intermediate(605-700)',
            ],[
                'name' => 'High Intermediate(705-780)',
            ],[
                'name' => 'Low Advanced(785-900)',
            ],[
                'name' => 'Advanced(905-990)',
            ],
        ]);
    }
}
