<?php

use Illuminate\Database\Seeder;
use App\Prayer;
use Faker\Factory as Faker;


class PrayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();


        $prayerTypeIds = \App\Prayer_types::lists('id')->toArray();

        foreach(range(1, 30) as $index)
        {
            Prayer::create([

                'prayer_title' => $faker->sentence(1),
                'prayer_body'    => $faker->paragraph(14),
                'prayer_type_id'    => $faker->randomElement($prayerTypeIds),
                'user_id'        => 1

            ]);
        }
    }
}
