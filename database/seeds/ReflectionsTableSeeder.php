<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Reflection;

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

        $readingIds     = \App\Reading::lists('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            Reflection::create([

                'reflection_body'   => $faker->sentence(20),
                'reflection_date'   => $faker->dateTime,
                'reading_id'        => $faker->randomElement($readingIds),
                'user_id'           => 1

            ]);
        }
    }
}
