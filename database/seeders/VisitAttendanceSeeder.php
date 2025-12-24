<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitAssignment;
use App\Models\VisitAttendance;

class VisitAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil assignment yang sudah ACTIVE
        $assignments = VisitAssignment::where('status', 'ACTIVE')->get();

        foreach ($assignments as $assignment) {
            
            // Simulasi: Teknisi Check-in
            VisitAttendance::create([
                'user_id' => $assignment->ts_id, // User ID harus sama dengan yang ditugaskan
                'visit_assignment_id' => $assignment->assignment_id,
                'check_in_time' => now()->subHours(2),
                'check_in_location' => '-7.2575, 112.7521', // Koordinat dummy Surabaya
                'check_in_photo' => 'dummy_checkin.jpg',
                
                // Opsional: Langsung Check-out untuk data dummy yang 'selesai'
                'check_out_time' => now(),
                'check_out_location' => '-7.2575, 112.7521',
                'check_out_photo' => 'dummy_checkout.jpg',
                'work_report' => 'Perbaikan selesai, router diganti baru.',
            ]);

            // Opsional: Update status assignment/ticket jika perlu
            // $assignment->ticket->update(['status' => 'COMPLETED']);
        }
    }
}