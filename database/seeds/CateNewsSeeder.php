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
        $faker = Faker\Factory::create();
        //
        for ($i = 0; $i <= 20; $i++) {
            \App\Model\CateNewsModel::create([
                'name' => $faker->name,
                'slug' => $faker->slug,
            ]);
        }

    }
}
