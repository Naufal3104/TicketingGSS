<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitAttendance extends Model
{
    use HasFactory;

    protected $table = 'visit_attendances';

    protected $fillable = [
        'user_id',
        'visit_assignment_id',
        'check_in_time',
        'check_in_location',
        'check_in_photo',
        'check_out_time',
        'check_out_location',
        'check_out_photo',
        'work_report',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    // Relasi ke Assignment
    public function assignment()
    {
        return $this->belongsTo(VisitAssignment::class, 'visit_assignment_id', 'assignment_id');
    }

    // Relasi ke User (Teknisi)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}