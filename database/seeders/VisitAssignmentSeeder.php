<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitTicket;
use App\Models\VisitAssignment;
use App\Models\User;

class VisitAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil tiket yang statusnya OPEN
        $tickets = VisitTicket::where('status', 'OPEN')->take(5)->get();
        
        // Ambil User (Anggaplah semua user bisa jadi teknisi untuk dummy data ini)
        $technicians = User::all();

        if ($tickets->isEmpty() || $technicians->isEmpty()) {
            return;
        }

        foreach ($tickets as $ticket) {
            $tech = $technicians->random();

            // Create Assignment
            VisitAssignment::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'ts_id' => $tech->user_id, // Penting: Masukkan user_id (string), bukan id (int)
                'assignment_type' => 'REGULAR',
                'status' => 'ACTIVE',
                'note' => 'Penugasan otomatis dari sistem',
                'assigned_at' => now(),
            ]);

            // Update status tiket menjadi ASSIGNED
            $ticket->update(['status' => 'ASSIGNED']);
        }
    }
}