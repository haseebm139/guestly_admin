<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Feature;

class PlanFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => '1 Active Studio Request at a Time', 'code' => 'studio_request_single'],
            ['name' => 'Basic Guest Artist Profile', 'code' => 'guest_artist_basic_profile'],
            ['name' => 'Messaging with Studios (Limited)', 'code' => 'studio_messaging_limited'],
            ['name' => 'Studio Calendar Viewing (Read-Only)', 'code' => 'calendar_read_only'],
            ['name' => 'Studio Seat Availability View', 'code' => 'seat_availability_view'],
            ['name' => 'Multiple Studio Requests', 'code' => 'studio_request_multiple'],
            ['name' => 'Pro Artist Profile', 'code' => 'pro_artist_profile'],
            ['name' => 'Unlimited Messaging', 'code' => 'unlimited_messaging'],
            ['name' => 'Calendar Booking Control', 'code' => 'calendar_control'],
            ['name' => 'Studio Seat Booking', 'code' => 'seat_booking'],
        ];

        // Seed all features
        foreach ($features as $featureData) {
            Feature::firstOrCreate(['code' => $featureData['code']], $featureData);
        }

        // Create Plans
        $freePlan = Plan::firstOrCreate([
            'name' => 'Free Tier',
        ], [
            'm_price' => 0.00,
            'y_price' => 0.00,
            'validity_value' => 1,
            'validity_unit' => 'months',

        ]);

        $proPlan = Plan::firstOrCreate([
            'name' => 'Pro Tier',
        ], [
            'm_price' => 9.99,
            'y_price' => 19.99,
            'validity_value' => 1,
            'validity_unit' => 'months',

        ]);

        $premiumPlan = Plan::firstOrCreate([
            'name' => 'Premium Tier',
        ], [
            'm_price' => 19.99,
            'y_price' => 190.99,
            'validity_value' => 1,
            'validity_unit' => 'months',

        ]);

        // Attach features
        $attach = function ($plan, $codes) {
            $features = Feature::whereIn('code', $codes)->pluck('id');
            $plan->features()->sync($features);
        };

        // Free Tier Features
        $attach($freePlan, [
            'studio_request_single',
            'guest_artist_basic_profile',
            'studio_messaging_limited',
            'calendar_read_only',
            'seat_availability_view',
        ]);

        // Pro Tier Features
        $attach($proPlan, [
            'studio_request_multiple',
            'pro_artist_profile',
            'unlimited_messaging',
            'calendar_read_only',
            'seat_availability_view',
        ]);

        // Premium Tier Features (all)
        $attach($premiumPlan, collect($features)->pluck('code')->toArray());
    }
}
