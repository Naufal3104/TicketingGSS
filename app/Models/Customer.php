<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VisitTicket;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone_number',
        'email',
        'address_primary',
        'status',
    ];

    public function visitTickets()
    {
        return $this->hasMany(VisitTicket::class, 'customer_id', 'customer_id');
    }

    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
}
