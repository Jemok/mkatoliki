<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Jumuiya;

class JumuiyasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $rawJIds     = \App\Raw_jumuiya::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            Jumuiya::create([

                'location' => $faker->sentence(1),
                'happening_on'    => $faker->dateTime,
                'raw_jumuiya_id'    => $faker->randomElement($rawJIds),
                'user_id'        => 1

            ]);
        }
    }
}
