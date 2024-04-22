<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Hash the password for security
            'admin' => true,
            'blocked' => false,
        ]);

        DB::table('users')->insert([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'admin' => false,
            'blocked' => false,
        ]);

        DB::table('devices')->insert([
            'device_name' => 'Default_Device',
            'username' => 'admin',
            'user_id' => 1,
            'password' => '123456',
            'endpoint' => '192.168.88.1',
            'method' => 'http'
        ]);
    }
}
