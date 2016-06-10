<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Subscription\Models\SubscriptionCategory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        SubscriptionCategory::create([
            'name' => 'annually',
            'days' => 365,
            'price' => 2000 ,
            'subscription_category' => 3,
            'user_id' => 1
        ]);

        SubscriptionCategory::create([
            'name' => 'monthly',
            'days' => 30,
            'price' => 200,
            'subscription_category' => 2,
            'user_id' => 1
        ]);

        SubscriptionCategory::create([
            'name' => 'weekly',
            'days' => 7,
            'price' => 50,
            'subscription_category' => 1,
            'user_id' => 1
        ]);

        Model::reguard();
    }
}
