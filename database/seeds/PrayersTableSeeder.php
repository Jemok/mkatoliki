<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Prayer\Models\Prayer;
use App\Api\V1\Prayer_Type\Models\Prayer_types;
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


        $prayerTypeIds = Prayer_types::lists('id')->toArray();

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
