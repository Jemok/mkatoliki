<?php

use Illuminate\Database\Seeder;
use App\Reading;
use Faker\Factory as Faker;
use App\User;

class ReadingsTableSeeder extends Seeder
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
            Reading::create([

                'reading_date' => $faker->dateTime,
                'reading_day'  => '2016-04-22 21:00:00',

                'first_reading_title'  => $faker->sentence(1),
                'first_reading_book' => $faker->word,
                'first_reading_body' => $faker->paragraph(10),

                'second_reading_title' => $faker->sentence(1),
                'second_reading_book' => $faker->word,
                'second_reading_body' => $faker->paragraph(10),

                'responsorial_title' => $faker->sentence(1),
                'responsorial_book'  =>  $faker->word,
                'responsorial_body_one' => $faker->paragraph(10),
                'responsorial_body_one_verse' => $faker->paragraph(4),
                'responsorial_body_two'     => $faker->paragraph(10),

                'gospel_title'   => $faker->sentence(1),
                'gospel_book'    => $faker->word,
                'gospel_body'    => $faker->paragraph(10),

                'user_id'    => 1

            ]);
        }
    }
}
