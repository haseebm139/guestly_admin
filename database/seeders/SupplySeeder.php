<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supply; // Import the Supply model

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplies = [
            ['name' => 'Ink', 'description' => 'Various colors and types of tattoo ink.'],
            ['name' => 'Stencil', 'description' => 'Stencil paper and solution.'],
            ['name' => 'Needle', 'description' => 'Assorted tattoo needles (liners, shaders).'],
            ['name' => 'Gloves', 'description' => 'Disposable nitrile gloves.'],
            ['name' => 'Disinfectant', 'description' => 'Medical-grade surface disinfectants.'],
            ['name' => 'Paper Towels', 'description' => 'Disposable paper towels for cleaning.'],
            ['name' => 'Green Soap', 'description' => 'Antiseptic soap for cleaning skin.'],
            ['name' => 'Barrier Film', 'description' => 'Protective film for equipment.'],
        ];

        foreach ($supplies as $supplyData) {
            Supply::firstOrCreate(
                ['name' => $supplyData['name']], // Check if supply already exists by name
                $supplyData // Create if not found
            );
        }
    }
}
