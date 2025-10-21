<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@finance.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'name' => 'Finance Manager',
            'username' => 'user',
            'email' => 'user@finance.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        // Create Viewer Users (Contoh: Staff yang minta pembelian)
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@company.com',
            'password' => Hash::make('viewer123'),
            'role' => 'viewer',
            'phone' => '081234567892',
            'company' => 'PT. Contoh Indonesia',
            'address' => 'Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'username' => 'siti',
            'email' => 'siti@company.com',
            'password' => Hash::make('viewer123'),
            'role' => 'viewer',
            'phone' => '081234567893',
            'company' => 'PT. Contoh Indonesia',
            'address' => 'Bandung',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Hidayat',
            'username' => 'ahmad',
            'email' => 'ahmad@company.com',
            'password' => Hash::make('viewer123'),
            'role' => 'viewer',
            'phone' => '081234567894',
            'company' => 'PT. Contoh Indonesia',
            'address' => 'Surabaya',
            'email_verified_at' => now(),
        ]);
    }
}
