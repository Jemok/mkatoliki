<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Account\Models\User_parishes;
use App\Api\V1\Account\Models\User;
use App\Api\V1\Parish\Models\Parish;
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

        $parishIds     = Parish::lists('id')->toArray();

        $userIds      = User::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            User_parishes::create([

                'parish_id' => $faker->randomElement($parishIds),
                'user_id'   => $faker->randomElement($userIds)


            ]);
        }
    }
}
