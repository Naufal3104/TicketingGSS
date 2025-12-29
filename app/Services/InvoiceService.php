<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\VisitTicket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    /**
     * Create a Draft Invoice
     */
    public function createDraft(VisitTicket $ticket, array $data): Invoice
    {
        return DB::transaction(function () use ($ticket, $data) {
            // Generate Invoice ID: INV-YYYYMM-XXXX
            $dateStr = now()->format('Ym');
            $randomStr = strtoupper(Str::random(4));
            $invoiceId = "INV-{$dateStr}-{$randomStr}";

            $base = $data['amount_base'];
            $discount = $data['amount_discount'] ?? 0;
            $final = max(0, $base - $discount);

            $invoice = Invoice::create([
                'invoice_id' => $invoiceId,
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'sales_id' => Auth::id(),
                'amount_base' => $base,
                'amount_discount' => $discount,
                'amount_final' => $final,
                'status' => 'DRAFT',
            ]);

            Log::info("Triggering n8n Webhook: Invoice Draft Created - ID: {$invoice->invoice_id}");

            return $invoice;
        });
    }

    /**
     * Update Invoice (Sales Approval / Status Change)
     */
    public function updateInvoice(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $updateData = [
                'status' => $data['status'],
                'paid_at' => ($data['status'] === 'PAID') ? now() : (($data['status'] === 'DRAFT') ? null : $invoice->paid_at),
            ];

            // Re-calculate calculations if DRAFT and amounts are present
            if ($invoice->status === 'DRAFT' && isset($data['amount_base'])) {
                $base = $data['amount_base'];
                $discount = $data['amount_discount'] ?? $invoice->amount_discount;
                $updateData['amount_base'] = $base;
                $updateData['amount_discount'] = $discount;
                $updateData['amount_final'] = max(0, $base - $discount);
            }

            $invoice->update($updateData);

            Log::info("Triggering n8n Webhook: Invoice Updated - ID: {$invoice->invoice_id}");

            return $invoice;
        });
    }
}
