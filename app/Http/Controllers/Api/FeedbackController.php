<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerFeedback;
use App\Models\VisitTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Expecting JSON payload from n8n or public form.
     */
    public function store(Request $request)
    {
        // Validation
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'rating_ts' => 'required|integer|min:1|max:5',
            'rating_cs' => 'nullable|integer|min:1|max:5',
            'rating_sales' => 'nullable|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ticket = VisitTicket::findOrFail($request->visit_ticket_id);

        // Check if feedback already exists
        if ($ticket->feedback) {
            return response()->json(['message' => 'Feedback already submitted for this ticket.'], 409);
        }

        DB::beginTransaction();
        try {
            // Create Feedback
            $feedback = CustomerFeedback::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'rating_ts' => $request->rating_ts,
                'rating_cs' => $request->rating_cs,
                'rating_sales' => $request->rating_sales,
                'review_text' => $request->review_text,
            ]);

            // Update Ticket Status to CLOSED (or ARCHIVED)?
            // "CLOSED" status wasn't in the original enum (COMPLETED was), 
            // but let's assume we keep it COMPLETED or move to ARCHIVED.
            // Requirement says "Trigger update status tiket ke CLOSED".
            // Since "CLOSED" is not in migration enum ['UNVERIFIED', 'OPEN', 'BIDDING', 'ASSIGNED', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED', 'ARCHIVED'],
            // effectively 'COMPLETED' is the closure state. Or we can use 'ARCHIVED'.
            // Let's stick to 'ARCHIVED' as "Fully Closed".

            // However, verify if 'CLOSED' was added later? No.
            // Let's use 'ARCHIVED' to signal it's done-done.
            $ticket->update(['status' => 'ARCHIVED']);

            DB::commit();

            return response()->json([
                'message' => 'Feedback received successfully.',
                'data' => $feedback
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to save feedback: ' . $e->getMessage()], 500);
        }
    }
}
