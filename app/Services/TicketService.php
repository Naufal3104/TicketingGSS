<?php

namespace App\Services;

use App\Models\VisitTicket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * Create a new Visit Ticket
     */
    public function createTicket(array $data): VisitTicket
    {
        return DB::transaction(function () use ($data) {
            // 1. Generate Ticket ID (T-YmdHis-Rand)
            $timestamp = now()->format('YmdHis');
            $randomString = Str::upper(Str::random(3));
            $ticketId = "T-{$timestamp}-{$randomString}";

            // 2. Create Ticket Record
            $ticket = VisitTicket::create([
                'visit_ticket_id' => $ticketId,
                'customer_id' => $data['customer_id'],
                'created_by' => Auth::user()?->user_id ?? 'SYSTEM',
                'issue_category' => $data['issue_category'],
                'issue_description' => $data['issue_description'],
                'visit_address' => $data['visit_address'],
                'priority_level' => $data['priority_level'],
                'ts_quota_needed' => $data['ts_quota_needed'],
                'status' => 'OPEN',
            ]);

            // 3. Trigger Webhook (Fire & Forget logic moved here)
            try {
                Log::info("Triggering n8n Webhook: Ticket Created - ID: " . $ticketId);
                // Http::post(...) 
            } catch (\Exception $e) {
                // Silect fail for webhook
            }

            return $ticket;
        });
    }

    /**
     * Update an existing ticket
     */
    public function updateTicket(VisitTicket $ticket, array $data): VisitTicket
    {
        return DB::transaction(function () use ($ticket, $data) {
            $ticket->update([
                'customer_id' => $data['customer_id'],
                'issue_category' => $data['issue_category'],
                'issue_description' => $data['issue_description'],
                'visit_address' => $data['visit_address'],
                'priority_level' => $data['priority_level'],
                'ts_quota_needed' => $data['ts_quota_needed'],
                'status' => $data['status'] ?? $ticket->status,
            ]);

            return $ticket;
        });
    }
    /**
     * Claim a ticket (Technician takes a job)
     */
    public function claimTicket(string $ticketId, int $tsId)
    {
        return DB::transaction(function () use ($ticketId, $tsId) {
            // 1. Lock the Ticket for Update (Pessimistic Locking)
            $ticket = VisitTicket::where('visit_ticket_id', $ticketId)
                ->lockForUpdate()
                ->first();

            // 2. Validation: Is ticket still OPEN?
            if (!$ticket || $ticket->status !== 'OPEN') {
                throw new \Exception('Job offering is no longer available (Taken or Cancelled).');
            }

            // 3. Validation: TS Availability (Clash Check)
            // Check if this TS has any ongoing assignment (PENDING or ON_SITE)
            // Assuming VisitAssignment model is available
            $ongoingAssignment = \App\Models\VisitAssignment::where('ts_id', $tsId)
                ->whereIn('status', ['PENDING', 'ON_SITE'])
                ->exists();

            if ($ongoingAssignment) {
                throw new \Exception('You cannot take a new job while you have an active assignment.');
            }

            // 4. Create Assignment
            $assignment = \App\Models\VisitAssignment::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'ts_id' => $tsId,
                'status' => 'PENDING',
                'assigned_at' => now(),
            ]);

            // 5. Update Ticket Status
            $ticket->update(['status' => 'ASSIGNED']);

            // 6. Webhook
            try {
                Log::info("Triggering n8n Webhook: Job Taken - Ticket: {$ticket->visit_ticket_id} by TS: {$tsId}");
            } catch (\Exception $e) {
                // Ignore
            }

            return $assignment;
        });
    }
}
