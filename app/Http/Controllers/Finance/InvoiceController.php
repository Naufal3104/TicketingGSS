<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\VisitTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['ticket.customer', 'sales'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('finance.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ticketId = $request->query('ticket_id');
        $ticket = VisitTicket::findOrFail($ticketId);

        // Prevent duplicate invoices
        if ($ticket->invoice) {
            return redirect()->route('invoices.show', $ticket->invoice->invoice_id)
                ->with('warning', 'Invoice already exists for this ticket.');
        }

        // Potential Sales users (For now, just get all users or specific logic)
        // Ideally filter by role 'SALES' if role system is robust
        // $salesUsers = User::where('role', 'SALES')->get(); 
        // For MVP, if no specific role column in migration shown, we might skip or just use all

        return view('finance.invoices.create', compact('ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'amount_base' => 'required|numeric|min:0',
            'amount_discount' => 'nullable|numeric|min:0',
            // 'sales_id' => 'required|exists:users,user_id', // Optional if we auto-assign or pick
        ]);

        $ticket = VisitTicket::findOrFail($request->visit_ticket_id);

        // Generate Invoice ID: INV-YYYYMM-XXXX (Random 4 chars)
        $dateStr = now()->format('Ym');
        $randomStr = strtoupper(Str::random(4));
        $invoiceId = "INV-{$dateStr}-{$randomStr}";

        // Calculate Final
        $base = $request->amount_base;
        $discount = $request->amount_discount ?? 0;
        $final = max(0, $base - $discount);

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'invoice_id' => $invoiceId,
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'sales_id' => Auth::id(), // Assign to creator (CS) or passed sales_id
                'amount_base' => $base,
                'amount_discount' => $discount,
                'amount_final' => $final,
                'status' => 'DRAFT',
            ]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice->invoice_id)
                ->with('success', 'Draft Invoice Created Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['ticket.customer', 'sales']);
        return view('finance.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:DRAFT,SENT,PAID,CANCELLED',
        ]);

        $invoice->update([
            'status' => $request->status,
            // Update paid_at if status becomes PAID
            'paid_at' => $request->status === 'PAID' ? now() : ($request->status === 'DRAFT' ? null : $invoice->paid_at),
        ]);

        return back()->with('success', 'Invoice status updated to ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
