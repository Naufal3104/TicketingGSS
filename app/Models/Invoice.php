<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VisitTicket; // Added this import
use App\Models\User; // Added this import

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $primaryKey = 'invoice_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'invoice_id',
        'visit_ticket_id',
        'sales_id',
        'amount_base',
        'amount_discount',
        'amount_final',
        'status',
        'payment_proof_url',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(VisitTicket::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id', 'user_id');
    }
}
