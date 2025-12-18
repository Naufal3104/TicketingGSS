<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\VisitAssignment;
use App\Models\VisitTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of OPEN jobs for TS.
     */
    /**
     * Display a listing of OPEN jobs for TS.
     */
    public function index()
    {
        $tsId = Auth::id();

        // 1. Open Tickets (Pool)
        $openTickets = VisitTicket::with('customer')
            ->open()
            ->orderBy('priority_level', 'desc') // Urgent first
            ->orderBy('created_at', 'asc') // Oldest first
            ->get();

        // 2. My Assignments (Active)
        $myAssignments = \App\Models\VisitAssignment::with('ticket')
            ->where('ts_id', $tsId)
            ->whereIn('status', ['PENDING', 'ON_SITE', 'DONE']) // Show history too? Maybe limit to active for now or all
            ->orderBy('assigned_at', 'desc')
            ->get();

        return view('operational.assignments.index', compact('openTickets', 'myAssignments'));
    }

    /**
     * TS takes a job (FCFS Logic).
     */
    public function takeJob(Request $request)
    {
        $validated = $request->validate([
            'visit_ticket_id' => 'required|string|exists:visit_tickets,visit_ticket_id',
        ]);

        $tsId = Auth::id(); // Currently logged in TS

        if (!$tsId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            DB::beginTransaction();

            // 1. Lock the Ticket for Update (Pessimistic Locking)
            // This ensures no other process can modify this ticket's state while we check it
            $ticket = VisitTicket::where('visit_ticket_id', $validated['visit_ticket_id'])
                ->lockForUpdate()
                ->first();

            // 2. Validation: Is ticket still OPEN?
            if (!$ticket || $ticket->status !== 'OPEN') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Job offering is no longer available (Taken or Cancelled).'
                ], 409); // Conflict
            }

            // 3. Validation: TS Quota (Simple Logic: If OPEN, it needs someone)
            // If we implement partial quota later, check here if (current_assignments < quota_needed)

            // 4. Validation: TS Availability (Clash Check)
            // Check if this TS has any ongoing assignment (PENDING or ON_SITE)
            $ongoingAssignment = VisitAssignment::where('ts_id', $tsId)
                ->whereIn('status', ['PENDING', 'ON_SITE'])
                ->exists();

            if ($ongoingAssignment) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot take a new job while you have an active assignment.'
                ], 422);
            }

            // 5. Create Assignment
            $assignment = VisitAssignment::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'ts_id' => $tsId,
                'status' => 'PENDING',
                'assigned_at' => now(),
            ]);

            // 6. Update Ticket Status
            // Assuming 1 Ticket = 1 Assignment (Job Taken)
            $ticket->status = 'ASSIGNED';
            $ticket->save();

            DB::commit();

            // Trigger n8n Webhook: Job Taken
            try {
                // Http::post(env('N8N_WEBHOOK_URL_JOB_TAKEN'), ['ticket_id' => $ticket->visit_ticket_id, 'ts_id' => $tsId]);
                \Illuminate\Support\Facades\Log::info("Triggering n8n Webhook: Job Taken - Ticket: {$ticket->visit_ticket_id} by TS: {$tsId}");
            } catch (\Exception $e) {
            }

            return response()->json([
                'success' => true,
                'message' => 'Job taken successfully!',
                'data' => $assignment
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to take job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified assignment (Job Detail).
     * Using Ticket ID for simpler URL context.
     */
    public function show($ticketId)
    {
        $ticket = VisitTicket::with(['customer', 'assignment', 'documents', 'creator'])
            ->where('visit_ticket_id', $ticketId)
            ->firstOrFail();

        // Security check: Is this TS assigned?
        // Or is it a CS viewing? For now, if TS, check assignment.
        $user = Auth::user();

        // Simple check for TS role (adjust based on actual Role implementation)
        // Assuming we rely on the existence of an assignment for this user
        if ($user->hasRole('technician')) { // specific role check if avaiable, else check assignment
            if ($ticket->assignment && $ticket->assignment->ts_id !== $user->id) {
                abort(403, 'Unauthorized access to this assignment.');
            }
        }

        return view('operational.assignments.show', compact('ticket'));
    }
}
