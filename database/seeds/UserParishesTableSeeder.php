<?php

use Illuminate\Database\Seeder;
use App\User_parishes;
use Faker\Factory as Faker;


class UserParishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $parishIds     = \App\Parish::lists('id')->toArray();

        $userIds      = \App\User::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            User_parishes::create([

                'parish_id' => $faker->randomElement($parishIds),
                'user_id'   => $faker->randomElement($userIds)


            ]);
        }
    }
}
