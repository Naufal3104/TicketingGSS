<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VisitTicket; // Added
use App\Models\User; // Added

class VisitDocument extends Model
{
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'visit_ticket_id',
        'uploader_id',
        'document_type',
        'file_url',
        'file_name',
        'description',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(VisitTicket::class, 'visit_ticket_id', 'visit_ticket_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id', 'user_id');
    }

    /** @use HasFactory<\Database\Factories\VisitDocumentFactory> */
    use HasFactory;
}
