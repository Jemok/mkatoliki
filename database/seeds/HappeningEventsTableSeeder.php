<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Happening_event;

class HappeningEventsTableSeeder extends Seeder
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
            Happening_event::create([

                'event_title' => $faker->sentence(1),
                'event_body'    => $faker->paragraph(5),
                'event_excerpt'    => $faker->paragraph(3),
                'event_date'        => $faker->dateTime,
                'user_id'        => 1

            ]);
        }
    }
}
