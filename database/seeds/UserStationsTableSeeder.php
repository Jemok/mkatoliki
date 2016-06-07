<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Api\V1\Account\Models\User_stations;
use App\Api\V1\Parish\Models\Parish;
use App\Api\V1\Account\Models\User;



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

        $stationIds     = Parish::lists('id')->toArray();

        $userIds      = User::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            User_stations::create([

                'station_id' => $faker->randomElement($stationIds),
                'user_id'   => $faker->randomElement($userIds)
            ]);
        }
    }
}
