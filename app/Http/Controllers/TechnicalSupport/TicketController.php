<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use App\Models\VisitTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(\App\Services\TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = VisitTicket::with('customer');

        // Check explicit roles if using Spatie Permission or simple logic
        // Assuming user has 'roles' relation or we check methods
        // For MVP without full role setup in User model, we might deduce from elsewhere or just show all for now
        // But the requirement asked for role-based logic.

        // If we use $user->hasRole('TS')
        if ($user->hasRole('TS')) {
            // TS sees tickets assigned to them
            $query->whereHas('assignments', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user->hasRole('CS')) {
            // CS sees all or maybe usually created by them? Let's say all for collaboration
            // No filter
        }

        // Default sort
        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('operational.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = \App\Models\Customer::all(); // Simple fetch for MVP
        return view('operational.tickets.form', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\Operational\StoreTicketRequest $request)
    {
        try {
            // Delegate logic to Service
            $ticket = $this->ticketService->createTicket($request->validated());

            return redirect()->route('tickets.create')->with('success', 'Ticket created successfully! ID: ' . $ticket->visit_ticket_id);
        } catch (\Exception $e) {
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
    public function edit(VisitTicket $ticket)
    {
        $customers = \App\Models\Customer::all();
        // Kita gunakan view yang sama dengan create, tapi kirim data $ticket
        return view('operational.tickets.form', compact('customers', 'ticket'));
    }

    public function update(\App\Http\Requests\Operational\UpdateTicketRequest $request, VisitTicket $visitTicket)
    {
        try {
            $this->ticketService->updateTicket($visitTicket, $request->validated());

            return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully: ' . $visitTicket->visit_ticket_id);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Failed to update ticket: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitTicket $visitTicket)
    {
        try {
            // Opsional: Cek apakah tiket sudah ada assignment atau progress sebelum delete
            if ($visitTicket->status !== 'OPEN') {
                return back()->withErrors(['msg' => 'Hanya tiket berstatus OPEN yang bisa dihapus.']);
            }

            $visitTicket->delete();
            return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Failed to delete ticket: ' . $e->getMessage()]);
        }
    }
}
