<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'visit_ticket_id',
        'rating_ts',
        'rating_cs',
        'rating_sales',
        'review_text',
    ];

    public function ticket()
    {
        return $this->belongsTo(VisitTicket::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    /** @use HasFactory<\Database\Factories\CustomerFeedbackFactory> */
    use HasFactory;
}
