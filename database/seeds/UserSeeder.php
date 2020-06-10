<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        User::create([
            'name' => 'Hà Đức Kiên',
            'email' => 'kienchidong@gmail.com',
            'password' => bcrypt('kien1997'),
            'gender' => 1,
            'phone' => '0392123325',
            'status' => 1
        ]);
        for($i =0; $i<=20; $i++){
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('12345678'),
                'gender' => random_int(0,2),
                'status' => random_int(0,1)
            ]);
        }
    }
}
