<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Api\V1\Reading\Models\Reading;

use App\Api\V1\Reflection\Models\Reflection;

class ReflectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $readingIds     = Reading::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            Reflection::create([

                'reflection_body'   => $faker->sentence(20),
                'reflection_date'   => \Carbon\Carbon::now(),
                'reading_id'        => $faker->randomElement($readingIds),
                'user_id'           => 1

            ]);
        }
    }
}
