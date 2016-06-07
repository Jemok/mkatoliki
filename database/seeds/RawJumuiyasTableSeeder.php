<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;

class RawJumuiyasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 30) as $index)
        {
            Raw_jumuiya::create([

                'jumuiya_name' => $faker->sentence(1),
                'jumuiya_image_link' => $faker->sentence(1),
                'user_id'        => 1

            ]);
        }
    }
}
