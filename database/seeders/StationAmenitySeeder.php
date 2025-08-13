<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StationAmenity;
use Illuminate\Support\Facades\DB;

class StationAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('studio_station_amenity')->delete();
        DB::table('studio_station_amenity')->truncate();
        $stationAmenities = [
            [
                'name' => 'Studio Manager or Assistant On Site',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/studiomanager.png'
            ],
            [
                'name' => '24/7 Studio Access',
                'description' => 'Artists can access the studio at any time.',
                'icon' => 'amenities_icon/clock.png'
            ],
            [
                'name' => 'Station Set Up and Break Down',
                'description' => 'Assistance with setting up and breaking down the tattoo station.',
                'icon' => 'amenities_icon/broom.png'
            ],
            [
                'name' => 'Photo Station',
                'description' => 'A designated area for taking high-quality photos of tattoos.',
                'icon' => 'amenities_icon/camera.png'
            ],
            [
                'name' => 'Stencil Printer',
                'description' => 'A printer specifically for stencils.',
                'icon' => 'amenities_icon/printer.png'
            ],
            [
                'name' => 'Color Printer',
                'description' => 'A printer specifically for stencils.',
                'icon' => 'amenities_icon/printer.png'
            ],
            [
                'name' => 'Adjustable Tattoo Chair or Table ',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/adjustablechair.png'
            ],
            [
                'name' => 'Autoclave',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/autoclave.png'
            ],
            [
                'name' => 'Bathroom Access',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/bathroom.png'
            ],
            [
                'name' => 'Microwave',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/microwave.png'
            ],
            [
                'name' => 'Fridge',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/fridge.png'
            ],
            [
                'name' => 'Artist Lounge',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/lounge.png'
            ],
            [
                'name' => 'Secure Locker or Storage',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/securelocker.png'
            ],
            [
                'name' => 'Social Media Promotion',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/socialmediapromtion.png'
            ],
            [
                'name' => 'Client Consent Form',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/form.png'
            ],
            [
                'name' => 'Parking',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/parking.png'
            ],
            [
                'name' => 'Nearby Public Transport',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/nearbypublictransport.png'
            ],

        ];


        foreach ($stationAmenities as $amenityData) {
            // StationAmenity::firstOrCreate(
            //     ['name' => $amenityData['name']],
            //     $amenityData
            // );
            StationAmenity::updateOrCreate(
                ['name' => $amenityData['name']], // Search condition
                $amenityData // Always updates if found, creates if not
            );
        }
    }
}
