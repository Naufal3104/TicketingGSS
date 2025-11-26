<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VisitTicket;

class VisitAssignment extends Model
{
    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'visit_ticket_id',
        'ts_id',
        'assigned_at',
        'google_event_id',
        'check_in_time',
        'check_out_time',
        'check_in_location',
        'work_report',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(VisitTicket::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function ts()
    {
        return $this->belongsTo(User::class, 'ts_id', 'user_id');
    }

    /** @use HasFactory<\Database\Factories\VisitAssignmentFactory> */
    use HasFactory;
}
