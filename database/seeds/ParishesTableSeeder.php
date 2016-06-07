<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Parish\Models\Parish;
use Faker\Factory as Faker;


class ParishesTableSeeder extends Seeder
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
            Parish::create([

                'parish_name' => $faker->sentence(1),
                'user_id'   => 1
            ]);
        }
    }
}
