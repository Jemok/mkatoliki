<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Station;

class StationsTableSeeder extends Seeder
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

        foreach(range(1, 30) as $index)
        {
            Station::create([

                'station_name' => $faker->sentence(1),
                'parish_id'    => $faker->randomElement($parishIds),
                'user_id'      => 1

            ]);
        }
    }
}
