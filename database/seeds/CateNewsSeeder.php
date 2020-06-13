<?php

use Illuminate\Database\Seeder;

class CateNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\CateNewsModel::create([
            'name' => 'Linh tinh',
            'slug' => 'linh-tinh.html',
        ], [
            'name' => 'Học tập',
            'slug' => 'hoc-tap.html',
        ]);

    }
}
