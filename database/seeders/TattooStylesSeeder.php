<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TattooStyle;

class TattooStylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tatoo = [
            ['name' => 'Fine Line', 'icon' => '✍️'],
            ['name' => 'Watercolor', 'icon' => '🎨'],
            ['name' => 'Black and Grey', 'icon' => '⚫️'],
            ['name' => 'Color', 'icon' => '🌈'],
            ['name' => 'Realism', 'icon' => '🖼️'],
        ];

        foreach ($tatoo as $tatooData) {
            TattooStyle::firstOrCreate(
                [
                    'name' => $tatooData['name'],
                    'icon'=>$tatooData['icon']
                ], // Check if supply already exists by name
                $tatooData // Create if not found
            );

        }
    }
}
