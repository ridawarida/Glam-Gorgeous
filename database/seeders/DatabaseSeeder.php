<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            TestDataSeeder::class,
        ]);

        Content::setValue('home_hero_title', 'Effortless Beauty, Unmistakable Style');
        Content::setValue('home_hero_subtitle', 'Sydney & Melbourne\'s curated hair & makeup for the modern muse.');
        Content::setValue('home_hero_button', 'Book Now');
        Content::setValue('home_about_title', 'About Us');
        Content::setValue('home_about_text', 'Lorem ipsum dolor sit amet et delectus, commodo his consuli egestas at vis ad quatunt delectus dicta uto.');
        Content::setValue('home_about_button', 'Learn More');
        Content::setValue('home_contact_title', 'Contact Us');
        Content::setValue('home_contact_text', 'Ready to book? Get in touch with us today.');
        Content::setValue('home_address', "123 Main Street, City\nSuite 1000\nCityville, Country");
    }
}
