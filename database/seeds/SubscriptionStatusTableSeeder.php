<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Subscription\Models\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;

class SubscriptionStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        SubscriptionStatus::create([
            'status_name' => 'initiated',
            'status_code' => 2,
            'user_id' => 1,
        ]);

        SubscriptionStatus::create([
            'status_name' => 'closed',
            'status_code' => 1,
            'user_id' => 1,
        ]);

        SubscriptionStatus::create([
            'status_name' => 'active',
            'status_code' => 0,
            'user_id' => 1,
        ]);

        SubscriptionStatus::create([
            'status_name' => 'confirmed',
            'status_code' => 3,
            'user_id' => 1,
        ]);

        SubscriptionStatus::create([
            'status_name' => 'cancelled',
            'status_code' => 4,
            'user_id' => 1,
        ]);

        Model::reguard();
    }
}
