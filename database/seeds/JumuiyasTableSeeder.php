<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Api\V1\Jumuiya\Models\Jumuiya;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;

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

        $rawJIds     = Raw_jumuiya::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            Jumuiya::create([

                'location' => $faker->sentence(1),
                'happening_on'    => \Carbon\Carbon::now(),
                'raw_jumuiya_id'    => $faker->randomElement($rawJIds),
                'user_id'        => 1

            ]);
        }
    }
}
