<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            // Hero Section
            'hero_title' => Content::getValue('home_hero_title', 'Beauty, Elevated.'),
            'hero_subtitle' => Content::getValue('home_hero_subtitle', 'Lorem ipsum dolor sit amet et delectus accommodare his consul oppossate legendos at vis ad putent dejectus delicata usu.'),
            'hero_button_text' => Content::getValue('home_hero_button_text', 'Book Now'),
            'hero_button_url' => Content::getValue('home_hero_button_url', '/booking/create'),
            
            // Reviews Section Title
            'reviews_title' => Content::getValue('home_reviews_title', 'What Our Clients Say'),
            'reviews_subtitle' => Content::getValue('home_reviews_subtitle', 'Real reviews from real clients'),
            
            // About Section
            'about_title' => Content::getValue('home_about_title', 'ABOUT US'),
            'about_text' => Content::getValue('home_about_text', 'Lorem ipsum dolor sit amet et delectus accommodare his consul oppossate legendos at vis ad putent dejectus delicata usu.'),
            'about_button_text' => Content::getValue('home_about_button_text', 'Read More'),
            'about_button_url' => Content::getValue('home_about_button_url', '#'),
            
            // Contact Section
            'contact_title' => Content::getValue('home_contact_title', 'Contact us'),
            'contact_subtitle' => Content::getValue('home_contact_subtitle', 'Have questions? We\'d love to hear from you.'),
            'contact_button_text' => Content::getValue('home_contact_button_text', 'Send Message'),
            
            // Footer
            'footer_address' => Content::getValue('home_footer_address', "L23 Main Street, City\nState Province, Country"),
            'footer_email' => Content::getValue('home_footer_email', 'hello@makeupstudio.com'),
            'footer_phone' => Content::getValue('home_footer_phone', '+61 400 000 000'),
            
            // Social Links
            'instagram_url' => Content::getValue('home_instagram_url', '#'),
            'facebook_url' => Content::getValue('home_facebook_url', '#'),
            'pinterest_url' => Content::getValue('home_pinterest_url', '#'),
        ];
        
        
        $reviews = Review::featured()
            ->with('user')
            ->latest()
            ->take(3)
            ->get();
        
        return view('home', compact('data', 'reviews'));
    }
}