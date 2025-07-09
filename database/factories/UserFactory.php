<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\TattooStyle;
use App\Models\Supply;
use App\Models\StationAmenity;
use App\Models\StudioImage;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'studio_name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'business_email' => $this->faker->unique()->companyEmail,
            'password' => bcrypt('12345'), // default password
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'bio' => $this->faker->paragraph,
            'language' => 'en',
            'website_url' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
            'emergency_phone' => $this->faker->phoneNumber,
            'front_doc' => null,
            'back_doc' => null,
            'google_id' => null,
            'facebook_id' => null,
            'apple_id' => null,
            'verification_type' => null,
            'avatar' => null,
            'document_front' => null,
            'document_back' => null,
            'studio_logo' => 'studios/logos/studio-logo-1752099461.png',
            'studio_cover' => 'studios/covers/studio-cover-1752099461.png',
            'guest_spots' => $this->faker->numberBetween(0, 5),
            'studio_type' => $this->faker->numberBetween(0, 3),
            'otp' => $this->faker->numberBetween(100000, 999999),
            'email_verified' => $this->faker->randomElement(['0', '1']),
            'role_id' => $this->faker->randomElement(['artist', 'studio']),
            'user_type' => $this->faker->randomElement(['artist', 'studio']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'verification_status' => $this->faker->randomElement(['0', '1', '2']),
            'require_portfolio' => $this->faker->randomElement(['0', '1']),
            'accept_bookings' => $this->faker->randomElement(['0', '1']),
            'preferred_duration' => $this->faker->randomElement(['0', '1']),
            'longitude' => 67.001137,
            'latitude' => 24.860735,
            'date_of_birth' => $this->faker->date(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $role = collect(['artist', 'studio'])->random();
            $images = collect(['studios/gallery/studio-gallery-1752099386-0.jpg',
                'studios/gallery/studio-gallery-1752099386-1.JPG',
                'studios/gallery/studio-gallery-1752099386-2.JPG',
                'studios/gallery/studio-gallery-1752099386-3.png',
                'studios/gallery/studio-gallery-1752099386-4.png'
            ])->random();
            $user->assignRole($role);
            $user->update([
                'user_type' => $role,
                'role_id' => $role,
            ]);
            $styleIds = TattooStyle::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray();
            $supplyIds = Supply::inRandomOrder()->take(rand(1, 8))->pluck('id')->toArray();
            $stationAmenitiesIds = StationAmenity::inRandomOrder()->take(rand(1, 8))->pluck('id')->toArray();

            if ($role === 'artist') {
                # code...
                $user->tattooStyles()->attach($styleIds);
            }else{
                $user->supplies()->attach($supplyIds);
                $user->stationAmenities()->attach($stationAmenitiesIds);

                $imagePaths = collect([
                'studios/gallery/studio-gallery-1752099386-0.jpg',
                'studios/gallery/studio-gallery-1752099386-1.JPG',
                'studios/gallery/studio-gallery-1752099386-2.JPG',
                'studios/gallery/studio-gallery-1752099386-3.png',
                'studios/gallery/studio-gallery-1752099386-4.png',
            ]);
            foreach ($imagePaths as $key=>$path) {
                StudioImage::create([
                    'user_id' => $user->id,
                    'image_path' => $imagePaths[$key],
                ]);
            }

            }
            // $user->studioImages()->attach($studio_imagesId);
        });
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
