<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Account\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'description' => 'Mkatoliki Admin',
            'role_power' => 0,
            'user_id'    => 1
        ]);

        Role::create([
            'description' => 'Parish Admin',
            'role_power' => 1,
            'user_id'    => 1
        ]);

        Role::create([
            'description' => 'Outstation Admin',
            'role_power' => 2,
            'user_id'    => 1
        ]);

        Role::create([
            'description' => 'Priest Admin',
            'role_power' => 3,
            'user_id'    => 1
        ]);

        Role::create([
            'description' => 'Mobile App User',
            'role_power' => 4,
            'user_id'    => 1
        ]);
    }
}
