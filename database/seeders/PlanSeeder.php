<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Monthly Plan',
            'slug' => 'monthly-plan',
            'stripe_name' => 'monthly',
            'stripe_id' => 'price_1KRfV1DHsbz9CBNMO409ZkNF',
            'price' => 2,
            'abbreviation' => '/monthly',
        ]);

        Plan::create([
            'name' => 'Yearly Plan',
            'slug' => 'yearly-plan',
            'stripe_name' => 'yearly',
            'stripe_id' => 'price_1KRfVLDHsbz9CBNMjEM3IlzS',
            'price' => 20 ,
            'abbreviation' => '/yearly',
        ]);
    }
}
