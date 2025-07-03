<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;
class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                [
                    'time_duration'=>'Weekly',
                    'offer_name'=>'Standard Offer',
                    'price'=>100,
                    'offer_title'=>'per week'
                ],
                [
                    'time_duration' => '15 Days',
                    'offer_name' => 'Fortnight Special',
                    'price'=>200,
                    'offer_title' => 'for 15 days'
                ],
                [
                    'time_duration' => '6 Months',
                    'offer_name' => 'Value Subscription',
                    'price'=>500,
                    'offer_title' => 'for 6 months'
                ]
        ];
        foreach ($data as $key => $value) {
            Subscription::create($value);
        }
    }
}
