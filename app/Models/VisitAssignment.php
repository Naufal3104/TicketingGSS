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
        'assignment_type',
        'status',
        'note',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime'
    ];

    public function ticket()
    {
        return $this->belongsTo(VisitTicket::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function ts()
    {
        return $this->belongsTo(User::class, 'ts_id', 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(VisitAttendance::class, 'visit_assignment_id', 'assignment_id');
    }

    /** @use HasFactory<\Database\Factories\VisitAssignmentFactory> */
    use HasFactory;
}
