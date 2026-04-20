<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Review;
use App\Models\User;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Categories
        $bridal = Category::updateOrCreate(['name' => 'Bridal']);
        $editorial = Category::updateOrCreate(['name' => 'Editorial']);
        $everyday = Category::updateOrCreate(['name' => 'Everyday']);
        $special = Category::updateOrCreate(['name' => 'Special Effects']);
        $hair = Category::updateOrCreate(['name' => 'Hair Styling']);

        // Services - Bridal
        Service::updateOrCreate(
            ['name' => 'Bridal Package'],
            [
                'description' => 'Complete bridal makeup including trial run, lashes, and long-lasting setting spray.',
                'price' => 450.00,
                'category_id' => $bridal->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Bridal Hair Styling'],
            [
                'description' => 'Elegant updo or bridal hairstyle with premium products and accessories.',
                'price' => 200.00,
                'category_id' => $hair->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Bridal Trial'],
            [
                'description' => 'Full bridal preview session including makeup and hair consultation.',
                'price' => 150.00,
                'category_id' => $bridal->id,
                'availability' => true,
            ]
        );

        // Services - Editorial
        Service::updateOrCreate(
            ['name' => 'Editorial Shoot'],
            [
                'description' => 'High-fashion makeup for photoshoots, runway, and editorial work.',
                'price' => 250.00,
                'category_id' => $editorial->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Creative Direction'],
            [
                'description' => 'Full creative consultation for editorial and commercial projects.',
                'price' => 180.00,
                'category_id' => $editorial->id,
                'availability' => true,
            ]
        );

        // Services - Everyday
        Service::updateOrCreate(
            ['name' => 'Everyday Glam'],
            [
                'description' => 'Natural, radiant makeup perfect for daily wear, brunch, or casual events.',
                'price' => 120.00,
                'category_id' => $everyday->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Express Makeup'],
            [
                'description' => 'Quick 30-minute makeup application for when you\'re on the go.',
                'price' => 85.00,
                'category_id' => $everyday->id,
                'availability' => true,
            ]
        );

        // Services - Special Effects
        Service::updateOrCreate(
            ['name' => 'SFX Makeup'],
            [
                'description' => 'Professional special effects makeup for film, TV, and events.',
                'price' => 300.00,
                'category_id' => $special->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Halloween Glam'],
            [
                'description' => 'Seasonal special - creative costume makeup and face painting.',
                'price' => 150.00,
                'category_id' => $special->id,
                'availability' => false,
            ]
        );

        // Services - Hair Styling
        Service::updateOrCreate(
            ['name' => 'Blowout & Style'],
            [
                'description' => 'Professional blow-dry and styling for any occasion.',
                'price' => 75.00,
                'category_id' => $hair->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Updo & Formal Style'],
            [
                'description' => 'Elegant updos, braids, and formal hairstyles for special events.',
                'price' => 120.00,
                'category_id' => $hair->id,
                'availability' => true,
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Hair Extensions'],
            [
                'description' => 'Professional extension application and styling.',
                'price' => 180.00,
                'category_id' => $hair->id,
                'availability' => true,
            ]
        );

        

        
        $client = User::where('email', 'test@example.com')->first();
        if ($client) {
            echo "Client ID: {$client->id}, Name: {$client->name}\n";
            Review::query()->update(['user_id' => $client->id]);
            Review::truncate();

        Review::updateOrCreate(
            ['content' => 'Absolutely stunning work! My bridal makeup lasted all day.'],
            [
                'user_id' => $client->id,
                'rating' => 5,
                'featured' => true,
            ]
        );

        Review::updateOrCreate(
            ['content' => 'Such a talented artist. Results were beyond expectations.'],
            [
                'user_id' => $client->id,
                'rating' => 5,
                'featured' => true,
            ]
        );

        Review::updateOrCreate(
            ['content' => 'Professional, punctual, and incredibly skilled!'],
            [
                'user_id' => $client->id,
                'rating' => 5,
                'featured' => true,
            ]
        );
    }
}}