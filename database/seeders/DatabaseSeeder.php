<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Import Role Spatie

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role (Pastikan tidak duplikat)
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleTS = Role::firstOrCreate(['name' => 'TS']);
        $roleCS = Role::firstOrCreate(['name' => 'CS']);
        $roleSales = Role::firstOrCreate(['name' => 'Sales']);

        // 2. Buat Akun Users

        // Admin
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            $admin = User::create([
                'user_id' => 'ADMIN001',
                'name' => 'Admin System',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password123'),
                'phone_number' => '081234567890',
                'is_active' => true,
            ]);
            $admin->assignRole($roleAdmin);
        }

        // CS (Customer Service)
        if (!User::where('email', 'cs@gmail.com')->exists()) {
            $cs = User::create([
                'user_id' => 'CS001',
                'name' => 'Customer Service 1',
                'email' => 'cs@gmail.com',
                'password' => bcrypt('password123'),
                'phone_number' => '081234567891',
                'is_active' => true,
            ]);
            $cs->assignRole($roleCS);
        }

        // Sales
        if (!User::where('email', 'sales@gmail.com')->exists()) {
            $sales = User::create([
                'user_id' => 'SALES001',
                'name' => 'Sales Representative',
                'email' => 'sales@gmail.com',
                'password' => bcrypt('password123'),
                'phone_number' => '081234567892',
                'is_active' => true,
            ]);
            $sales->assignRole($roleSales);
        }

        // TS (Technical Support)
        if (!User::where('email', 'ts1@gmail.com')->exists()) {
            $ts1 = User::create([
                'user_id' => 'TS001',
                'name' => 'Teknisi Satu',
                'email' => 'ts1@gmail.com',
                'password' => bcrypt('password123'),
                'phone_number' => '081234567893',
                'is_active' => true,
            ]);
            $ts1->assignRole($roleTS);
        }

        if (!User::where('email', 'ts2@gmail.com')->exists()) {
            $ts2 = User::create([
                'user_id' => 'TS002',
                'name' => 'Teknisi Dua',
                'email' => 'ts2@gmail.com',
                'password' => bcrypt('password123'),
                'phone_number' => '081234567894',
                'is_active' => true,
            ]);
            $ts2->assignRole($roleTS);
        }

        // 3. Panggil Seeder Lain
        $this->call([
            CustomerSeeder::class,
            VisitTicketSeeder::class,
            VisitAssignmentSeeder::class,
            VisitAttendanceSeeder::class,
        ]);
    }
}
