<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'id' => Str::uuid(),
            'name' => 'Admin Satu',
            'username' => 'admin',
            'password' => Hash::make('pastibisa'),
            'phone' => '081234567890',
            'email' => 'admin@example.com',
        ]);
    }
}
