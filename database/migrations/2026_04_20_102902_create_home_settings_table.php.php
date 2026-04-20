<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            ['key' => 'hero_tagline',        'value' => 'Beauty, Elevated.'],
            ['key' => 'hero_subtext',         'value' => 'Sydney\'s leading hair & makeup artist for weddings, editorials, and unforgettable events.'],
            ['key' => 'hero_cta_portfolio',   'value' => 'View Portfolio'],
            ['key' => 'hero_cta_book',        'value' => 'Book Now'],
            ['key' => 'about_heading',        'value' => 'About Us'],
            ['key' => 'about_text',           'value' => 'With over a decade of experience in bridal, editorial, and special effects artistry, we bring your vision to life with precision and passion.'],
            ['key' => 'about_cta',            'value' => 'Read More'],
            ['key' => 'contact_heading',      'value' => 'Contact Us'],
            ['key' => 'contact_subtext',      'value' => 'Have a question or ready to book? We\'d love to hear from you.'],
            ['key' => 'business_hours',       'value' => 'Mon – Sat: 9am – 6pm'],
            ['key' => 'response_time',        'value' => 'We reply within 24 hours.'],
            ['key' => 'location_area',        'value' => 'Sydney, Melbourne, Brisbane & surrounds'],
            ['key' => 'instagram_url',        'value' => '#'],
            ['key' => 'facebook_url',         'value' => '#'],
            ['key' => 'pinterest_url',        'value' => '#'],
            ['key' => 'footer_address',       'value' => 'Sydney, NSW, Australia'],
            ['key' => 'footer_email',         'value' => 'hello@makeupbooking.com.au'],
            ['key' => 'footer_phone',         'value' => '+61 400 000 000'],
        ];

        foreach ($defaults as $row) {
            DB::table('home_settings')->insert(array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};