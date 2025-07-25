<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $demoUser = User::create([
            'name'              => "Administrator",
            'email'             => 'demo@demo.com',
            'password'          => Hash::make('demo'),
            'role_id'           => "administrator",
            'user_type'           => "administrator",
            'email_verified_at' => now(),
        ]);

        $demoUser2 = User::create([
            'name'              => "Administrator User",
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('demo'),
            'role_id'           => "administrator",
            'user_type'           => "administrator",
            'email_verified_at' => now(),
        ]);

        $demoUser3 = User::create([
            'name'              => "Artist User",
            'email'             => 'artist@artist.com',
            'password'          => Hash::make('12345'),
            'role_id'           => "artist",
            'user_type'           => "artist",
            'email_verified_at' => now(),
        ]);
        $demoUser4 = User::create([
            'name'              => "Studio User",
            'email'             => 'studio@studio.com',
            'password'          => Hash::make('12345'),
            'role_id'           => "studio",
            'user_type'           => "studio",
            'email_verified_at' => now(),
        ]);
    }
}
