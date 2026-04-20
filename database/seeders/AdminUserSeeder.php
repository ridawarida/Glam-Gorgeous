<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@makeupstudio.com'],
            [
                'name' => 'Studio Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+61 400 000 000',
                'address' => '123 Studio Lane, Sydney NSW 2000',
            ]
        );
    }
}