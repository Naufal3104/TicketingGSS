<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. OPEN Tickets (Available for bidding/FCFS)
        $openTickets = [
            [
                'visit_ticket_id' => 'TICK-001',
                'customer_id' => 'CUST001',
                'created_by' => 'CS001',
                'issue_category' => 'Internet Slow',
                'issue_description' => 'User complains about slow bandwidth during peak hours.',
                'visit_address' => 'Jl. Thamrin No. 1, Jakarta Pusat',
                'priority_level' => 'HIGH',
                'ts_quota_needed' => 1,
                'status' => 'OPEN',
                'visit_date' => $now->addDays(1)->toDateString(),
                'visit_time' => '10:00:00',
            ],
            [
                'visit_ticket_id' => 'TICK-002',
                'customer_id' => 'CUST002',
                'created_by' => 'CS001',
                'issue_category' => 'Hardware Failure',
                'issue_description' => 'Router restart loop.',
                'visit_address' => 'Jl. Sudirman No. 50, Jakarta Selatan',
                'priority_level' => 'URGENT',
                'ts_quota_needed' => 1,
                'status' => 'OPEN',
                'visit_date' => $now->addDays(2)->toDateString(),
                'visit_time' => '14:00:00',
            ],
            [
                'visit_ticket_id' => 'TICK-003',
                'customer_id' => 'CUST003',
                'created_by' => 'CS001',
                'issue_category' => 'Installation',
                'issue_description' => 'New device installation request.',
                'visit_address' => 'Jl. Gatot Subroto No. 100, Jakarta Timur',
                'priority_level' => 'MEDIUM',
                'ts_quota_needed' => 1,
                'status' => 'OPEN',
                'visit_date' => $now->addDays(3)->toDateString(),
                'visit_time' => '09:00:00',
            ],
        ];

        foreach ($openTickets as $t) {
            \App\Models\VisitTicket::firstOrCreate(['visit_ticket_id' => $t['visit_ticket_id']], $t);
        }

        // 2. IN_PROGRESS Tickets (Taken by TS)
        $inProgressTicket1 = \App\Models\VisitTicket::firstOrCreate(['visit_ticket_id' => 'TICK-004'], [
            'customer_id' => 'CUST001',
            'created_by' => 'CS001',
            'issue_category' => 'Maintenance',
            'issue_description' => 'Routine maintenance check.',
            'visit_address' => 'Jl. Thamrin No. 1, Jakarta Pusat',
            'priority_level' => 'LOW',
            'ts_quota_needed' => 1,
            'status' => 'IN_PROGRESS',
            'visit_date' => $now->toDateString(),
            'visit_time' => '08:00:00',
        ]);

        \App\Models\VisitAssignment::firstOrCreate(['visit_ticket_id' => 'TICK-004'], [
            'ts_id' => 'TS001',
            'assigned_at' => $now->subHours(2),
            'status' => 'ON_SITE', // Corrected from IN_PROGRESS
            'check_in_time' => $now->subHour(),
            'check_in_location' => '-6.200000, 106.816666',
        ]);
        
        // 3. COMPLETED Tickets (Ready for invoicing)
        $completedTicket1 = \App\Models\VisitTicket::firstOrCreate(['visit_ticket_id' => 'TICK-005'], [
            'customer_id' => 'CUST004',
            'created_by' => 'CS001',
            'issue_category' => 'Cabling',
            'issue_description' => 'Replace broken LAN cables.',
            'visit_address' => 'Jl. Japati No. 1, Bandung', // Far location
            'priority_level' => 'MEDIUM',
            'ts_quota_needed' => 1,
            'status' => 'COMPLETED',
            'visit_date' => $now->subDays(1)->toDateString(),
            'visit_time' => '13:00:00',
        ]);
        
        \App\Models\VisitAssignment::firstOrCreate(['visit_ticket_id' => 'TICK-005'], [
            'ts_id' => 'TS002',
            'assigned_at' => $now->subDays(1)->subHours(5),
            'status' => 'DONE', // Corrected from COMPLETED
            'check_in_time' => $now->subDays(1)->subHours(4),
            'check_in_location' => '-6.914744, 107.609810',
            'check_out_time' => $now->subDays(1)->subHours(2),
            'work_report' => 'Replaced 50m of CAT6 cable and tested connectivity. All good.',
        ]);

        // 4. ARCHIVED/BILLED Tickets (Invoiced and Paid/Feedback)
        $closedTicket1 = \App\Models\VisitTicket::firstOrCreate(['visit_ticket_id' => 'TICK-006'], [
            'customer_id' => 'CUST005',
            'created_by' => 'CS001',
            'issue_category' => 'Device Config',
            'issue_description' => 'Configure firewall rules.',
            'visit_address' => 'Menara BCA, Jakarta',
            'priority_level' => 'HIGH',
            'ts_quota_needed' => 1,
            'status' => 'ARCHIVED',
            'visit_date' => $now->subDays(5)->toDateString(),
            'visit_time' => '10:00:00',
        ]);

        \App\Models\VisitAssignment::firstOrCreate(['visit_ticket_id' => 'TICK-006'], [
            'ts_id' => 'TS001',
            'assigned_at' => $now->subDays(5)->subHours(2),
            'status' => 'DONE', // Corrected from COMPLETED
            'check_in_time' => $now->subDays(5)->subHours(1),
            'check_in_location' => '-6.195000, 106.820000',
            'check_out_time' => $now->subDays(5)->addHour(),
            'work_report' => 'Firewall configured successfully.',
        ]);

        \App\Models\Invoice::firstOrCreate(['visit_ticket_id' => 'TICK-006'], [
            'invoice_id' => 'INV-202412-001',
            'sales_id' => 'SALES001',
            'amount_base' => 1500000,
            'amount_discount' => 0,
            'amount_final' => 1500000,
            'status' => 'PAID',
            'paid_at' => $now->subDays(3),
            'payment_proof_url' => 'http://example.com/proof.jpg',
        ]);

        \App\Models\CustomerFeedback::firstOrCreate(['visit_ticket_id' => 'TICK-006'], [
            'rating_ts' => 5,
            'rating_cs' => 4,
            'rating_sales' => 5,
            'review_text' => 'Excellent service, very professional.',
        ]);
        
    }
}
