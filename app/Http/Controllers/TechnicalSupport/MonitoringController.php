<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitTicket;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Display a monitoring dashboard for Field Operations.
     */
    public function index()
    {
        // Get visits scheduled for TODAY
        $today = Carbon::today()->toDateString();

        $todaysVisits = VisitTicket::with(['customer', 'assignment.ts', 'invoice'])
            ->whereDate('visit_date', $today)
            ->orderBy('visit_time', 'asc')
            ->get();

        // Calculate Stats
        $stats = [
            'total' => $todaysVisits->count(),
            'completed' => $todaysVisits->whereIn('status', ['COMPLETED', 'COMPLETED_PENDING_DOCS'])->count(),
            'on_site' => $todaysVisits->where('status', 'IN_PROGRESS')->count(),
            'pending' => $todaysVisits->whereIn('status', ['ASSIGNED', 'OPEN'])->count(),
        ];

        return view('operational.monitoring.index', compact('todaysVisits', 'stats', 'today'));
    }

    /**
     * Emergency Re-pool: Return ticket to Open Pool if TS is absent.
     */
    public function repool(Request $request, VisitTicket $ticket)
    {
        // Validation: Only if currently ASSIGNED or IN_PROGRESS (but stalled)
        if (!in_array($ticket->status, ['ASSIGNED', 'IN_PROGRESS'])) {
            return back()->with('error', 'Ticket status must be ASSIGNED or IN_PROGRESS to re-pool.');
        }

        // Logic:
        // 1. Set Status to OPEN
        // 2. Clear current assignment or mark it as CANCELLED/FAILED
        // 3. Log the reason

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Find active assignment
            $assignment = $ticket->assignment; // Assuming hasOne relationship or modify to find latest
            if ($assignment) {
                // $assignment->status = 'CANCELLED'; // Or 'FAILED'
                // $assignment->save();
                // Or soft delete? Let's assume we update status.
                $assignment->update(['status' => 'CANCELLED', 'notes' => 'Emergency Re-pool by CS']);
            }

            $ticket->update(['status' => 'OPEN']);

            \Illuminate\Support\Facades\DB::commit();

            return back()->with('success', 'Ticket returned to Open Pool successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', 'Failed to re-pool ticket: ' . $e->getMessage());
        }
    }
}
