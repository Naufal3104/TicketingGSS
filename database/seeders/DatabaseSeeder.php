<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Import Role Spatie

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleTS = Role::create(['name' => 'TS']);

        // 2. Buat Akun Admin
        $admin = User::create([
            'name' => 'Sang Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'), // password default
        ]);
        // Assign role admin ke user ini
        $admin->assignRole($roleAdmin);

        // 3. Buat Akun User Biasa
        $TS = User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        // Assign role user ke user ini
        $TS->assignRole($roleTS);
    }
}