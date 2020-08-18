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
        \App\Model\News\CateNewsModel::create([
            'name' => 'Học Toeic',
            'slug' => 'hoc-toeic.html',
        ], [
            'name' => 'Luyện Ngữ Pháp',
            'slug' => 'luyen-ngu-phap.html',
        ]);

    }
}
