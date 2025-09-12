<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
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

        $faker = Faker::create();

        User::factory(15)->create()->each(function ($user) use ($faker) {

            $role = "artist";

            $user->avatar = 'avatar/default.png';
            $user->password = Hash::make('password123');
            $user->user_type = $role;
            $user->role_id = $role;
            $user->save();


            $user->assignRole($role);
        });

        User::factory(15)->create()->each(function ($user) use ($faker) {

            $role = "studio";

            $user->avatar = 'avatar/default.png';
            $user->password = Hash::make('password123');
            $user->user_type = $role;
            $user->role_id = $role;
            $user->save();


            $user->assignRole($role);
        });
        
    }
}
