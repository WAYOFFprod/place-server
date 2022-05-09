<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();

        $password = Hash::make(env('ADMIN_PASSWORD', 'password'));

        User::create([
            'name' => env('ADMIN_USERNAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
            'password' => $password,
        ]);
    }
}
