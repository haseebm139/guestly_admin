<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DesignSpecialty;

class DesignSpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Traditional',
            'Neo‑traditional',
            'Realism',
            'Watercolor',
            'Japanese',
            'Geometric',
            'Tribal',
            'Minimalist',
            'Portrait',
            'Abstract',
        ];


        foreach ($specialties as $specialty) {
            DesignSpecialty::Create(
                ['name' => $specialty], // Check if supply already exists by name

            );
        }
    }
}
