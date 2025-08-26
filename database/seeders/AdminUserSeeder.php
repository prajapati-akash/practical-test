<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['user_email' => 'admin@example.com'], // unique email
            [
                'user_name' => 'Super Admin',
                'user_email' => 'admin@mailinator.com',
                'user_mobile_no' => '9999999999',
                'user_type' => 'admin',
                'user_status' => 'active',
                'activation_token' => Str::random(64),
                'password' => Hash::make('Test@123'),
            ]
        );
    }
}