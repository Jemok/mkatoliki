<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Prayer_Type\Models\Prayer_types;
use Faker\Factory as Faker;


class PrayerTypesTableSeeder extends Seeder
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
            Prayer_types::create([

                'prayer_type_name' => $faker->sentence(1),
                'prayer_type_description'    => $faker->paragraph(14),
                'user_id'        => 1

            ]);
        }
    }
}
