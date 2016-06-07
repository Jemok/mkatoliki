<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Account\Models\User;
use Faker\Factory as Faker;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'name' => $faker->userName,
            'email' => $faker->email,
            'phone_number' => $faker->phoneNumber,
            'password' => bcrypt('secret')
        ]);
    }
}
