<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StationAmenity;


class StationAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stationAmenities = [
            [
                'name' => 'Studio Manager or Assistant On Site',
                'description' => 'A manager or assistant is available to help.',
                'icon' => 'amenities_icon/manager.svg' // Example: path to an SVG icon
            ],
            [
                'name' => '24/7 Studio Access',
                'description' => 'Artists can access the studio at any time.',
                'icon' => 'amenities_icon/clock.svg' // Example: path to an SVG icon
            ],
            [
                'name' => 'Station Set Up and Break Down',
                'description' => 'Assistance with setting up and breaking down the tattoo station.',
                'icon' => 'amenities_icon/broom.svg' // Example: path to an SVG icon
            ],
            [
                'name' => 'Photo Station',
                'description' => 'A designated area for taking high-quality photos of tattoos.',
                'icon' => 'amenities_icon/camera.svg' // Example: path to an SVG icon
            ],
            [
                'name' => 'Stencil Printer',
                'description' => 'A printer specifically for stencils.',
                'icon' => 'amenities_icon/printer.svg' // Example: path to an SVG icon
            ],
        ];


        foreach ($stationAmenities as $amenityData) {
            StationAmenity::firstOrCreate(
                ['name' => $amenityData['name']],
                $amenityData
            );
        }
    }
}
