<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitTicket;
use App\Models\VisitAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Handle TS Check-in.
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $checkInAt = Carbon::now();

        // 1. Verify Ticket exists & User is Assigned
        // Assuming there is a relationship or logic to check assignment.
        // For MVP, if TS has the ID, we check if he is the assignee (via relation or directly).
        // Let's assume Ticket has 'current_assignee_id' or we check 'visit_assignments'.

        $ticket = VisitTicket::where('visit_ticket_id', $request->visit_ticket_id)->firstOrFail();

        // Ensure the logged in user is the assigned TS
        // Since we didn't see the exact relation in previous turns, we assume VisitAssignments or direct check.
        // Let's check the assignments table or relation.
        // PJV-002 Log says: VisitAssignment created and ticket status ASSIGNED.

        // Check if this TS is actually assigned to this ticket
        $isAssigned = DB::table('visit_assignments')
            ->where('visit_ticket_id', $ticket->visit_ticket_id)
            ->where('user_id', Auth::id())
            ->where('status', 'ACTIVE') // Assuming active assignment
            ->exists();

        if (!$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned to this ticket.',
            ], 403);
        }

        // 2. Check if already Checked-in (Active Attendance)
        $existingAttendance = VisitAttendance::where('visit_ticket_id', $ticket->visit_ticket_id)
            ->where('user_id', Auth::id())
            ->whereNull('check_out_at')
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'You are already checked in.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // 3. Create Attendance Record
            VisitAttendance::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'user_id' => Auth::id(),
                'check_in_at' => $checkInAt,
                'check_in_lat' => $request->latitude,
                'check_in_long' => $request->longitude,
            ]);

            // 4. Update Ticket Status
            $ticket->status = 'IN_PROGRESS';
            $ticket->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check-in successful.',
                'timestamp' => $checkInAt->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Check-in failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle TS Check-out.
     */
    public function checkOut(Request $request)
    {
        $request->validate([
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status_update' => 'required|in:ON_HOLD,COMPLETED_PENDING_DOCS', // TS decides if job is paused or done
        ]);

        $checkOutAt = Carbon::now();
        $ticket = VisitTicket::where('visit_ticket_id', $request->visit_ticket_id)->firstOrFail();

        // 1. Find active attendance
        $attendance = VisitAttendance::where('visit_ticket_id', $ticket->visit_ticket_id)
            ->where('user_id', Auth::id())
            ->whereNull('check_out_at')
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'No active check-in found for this ticket.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            // 2. Update Attendance
            $attendance->update([
                'check_out_at' => $checkOutAt,
                'check_out_lat' => $request->latitude,
                'check_out_long' => $request->longitude,
            ]);

            // 3. Update Ticket Status
            $ticket->status = $request->status_update;
            $ticket->save();

            // If status is COMPLETED_PENDING_DOCS, maybe we should also close the assignment?
            // For now, let's just keep the status update.

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check-out successful.',
                'timestamp' => $checkOutAt->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Check-out failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
