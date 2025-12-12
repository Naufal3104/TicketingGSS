<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\VisitTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Implement listing based on role
        return response()->json(['message' => 'Listing not implemented yet'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = \App\Models\Customer::all(); // Simple fetch for MVP
        return view('operational.tickets.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'issue_category' => 'required|string|max:50',
            'issue_description' => 'required|string',
            'visit_address' => 'required|string',
            'priority_level' => 'required|in:LOW,MEDIUM,HIGH,URGENT',
            'ts_quota_needed' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 2. Generate Ticket ID (T-YmdHis-Rand)
            // Example: T-20231027100000-ABC
            $timestamp = now()->format('YmdHis');
            $randomString = Str::upper(Str::random(3));
            $ticketId = "T-{$timestamp}-{$randomString}";

            // 3. Create Ticket
            $ticket = VisitTicket::create([
                'visit_ticket_id' => $ticketId,
                'customer_id' => $validated['customer_id'],
                'created_by' => Auth::id() ?? 'SYSTEM', // Fallback if no auth yet
                'issue_category' => $validated['issue_category'],
                'issue_description' => $validated['issue_description'],
                'visit_address' => $validated['visit_address'],
                'priority_level' => $validated['priority_level'],
                'ts_quota_needed' => $validated['ts_quota_needed'],
                'status' => 'OPEN',
            ]);

            DB::commit();

            return redirect()->route('tickets.create')->with('success', 'Ticket created successfully! ID: ' . $ticketId);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['msg' => 'Failed to create ticket: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VisitTicket $visitTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitTicket $visitTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitTicket $visitTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitTicket $visitTicket)
    {
        //
    }
}
