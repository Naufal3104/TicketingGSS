<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\VisitTicket;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

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
    public function store(\App\Http\Requests\Finance\StoreInvoiceRequest $request)
    {
        // Validation handled by FormRequest
        // $request->validated() is available but we can also access $request properties directly if needed,
        // but explicit validated() is cleaner.

        $ticket = VisitTicket::findOrFail($request->visit_ticket_id);

        try {
            $invoice = $this->invoiceService->createDraft($ticket, $request->validated());

            return redirect()->route('invoices.show', $invoice->invoice_id)
                ->with('success', 'Draft Invoice Created Successfully!');
        } catch (\Exception $e) {
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
    public function update(\App\Http\Requests\Finance\UpdateInvoiceRequest $request, Invoice $invoice)
    {
        // Validation handled by FormRequest
        // Note: UpdateInvoiceRequest should allow amounts to be nullable

        try {
            $this->invoiceService->updateInvoice($invoice, $request->validated());

            return back()->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
