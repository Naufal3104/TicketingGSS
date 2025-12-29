<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use App\Models\VisitAssignment;
use App\Models\VisitTicket;
use App\Services\TicketService; // Added for the new service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

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
        $myAssignments = VisitAssignment::with('ticket')
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

        $user = Auth::user();
        // Pastikan user memiliki user_id (karena di database kolom ini nullable)
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Assuming Auth::id() is what we used in service for ts_id, or user_id property
        // Service expects int tsId. Auth::id() returns int usually.
        $tsId = Auth::id();

        try {
            $assignment = $this->ticketService->claimTicket($validated['visit_ticket_id'], $tsId);

            return response()->json([
                'success' => true,
                'message' => 'Job taken successfully!',
                'data' => $assignment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to take job: ' . $e->getMessage()
            ], 409); // Conflict or Bad Request
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
