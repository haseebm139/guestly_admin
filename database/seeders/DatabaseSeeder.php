<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            RolesPermissionsSeeder::class,
            PlanFeatureSeeder::class,
            SupplySeeder::class,
            StationAmenitySeeder::class,
            TattooStylesSeeder::class,
            DesignSpecialtiesSeeder::class,

        ]);



        \App\Models\User::factory(30)->create()->each(function ($user) {
            $role = collect(['artist', 'studio'])->random();

            // Set user_type column (optional)
            $user->user_type = $role;
            $user->role_id = $role;
            $user->save();

            // Assign role via Spatie
            $user->assignRole($role);
        });
        // \App\Models\User::factory(30)->create();

        // \App\Models\User::factory(10)->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'longitude' => 67.001137,
        //     'latitude' => 24.860735,
        // ]);
    }
}
