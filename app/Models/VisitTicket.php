<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\User;
use App\Models\VisitAssignment;
use App\Models\VisitDocument;
use App\Models\Invoice;
use App\Models\CustomerFeedback;

class VisitTicket extends Model
{
    /** @use HasFactory<\Database\Factories\VisitTicketFactory> */
    use HasFactory;

    protected $primaryKey = 'visit_ticket_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'visit_ticket_id',
        'customer_id',
        'created_by',
        'issue_category',
        'issue_description',
        'visit_address',
        'priority_level',
        'ts_quota_needed',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function assignment()
    {
        return $this->hasMany(VisitAssignment::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function documents()
    {
        return $this->hasMany(VisitDocument::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function feedback()
    {
        return $this->hasOne(CustomerFeedback::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'OPEN');
    }
}
