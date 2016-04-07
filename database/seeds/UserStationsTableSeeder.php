<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User_stations;



class UserStationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $stationIds     = \App\Parish::lists('id')->toArray();

        $userIds      = \App\User::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            User_stations::create([

                'station_id' => $faker->randomElement($stationIds),
                'user_id'   => $faker->randomElement($userIds)
            ]);
        }
    }
}
