<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitTicket;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;

class VisitTicketSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada Customer dan User
        $customers = Customer::all();
        $users = User::all();

        if ($customers->count() == 0 || $users->count() == 0) {
            $this->command->info('Please seed Users and Customers first.');
            return;
        }

        // Buat 10 Tiket Dummy
        for ($i = 1; $i <= 10; $i++) {
            $ticketId = 'T-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
            
            VisitTicket::create([
                'visit_ticket_id' => $ticketId,
                'customer_id' => $customers->random()->customer_id,
                'created_by' => $users->random()->user_id, // Mengambil user acak sebagai pembuat
                'issue_category' => 'Network Issue',
                'issue_description' => 'Koneksi internet lambat dan sering putus di lantai ' . rand(1, 3),
                'visit_address' => 'Jl. Contoh No. ' . $i . ', Surabaya',
                'priority_level' => collect(['LOW', 'MEDIUM', 'HIGH', 'URGENT'])->random(),
                'ts_quota_needed' => rand(1, 2),
                'status' => 'OPEN', // Default OPEN agar bisa diambil job-nya
            ]);
        }
    }
}