<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'username',
        'name',
        'full_name',
        'email',
        'phone_number',
        'telegram_chat_id',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    public function visitAssignments()
    {
        return $this->hasMany(VisitAssignment::class, 'ts_id', 'user_id');
    }

    public function visitDocuments()
    {
        return $this->hasMany(VisitDocument::class, 'uploader_id', 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'sales_id', 'user_id');
    }

    public function kpiMonthly()
    {
        return $this->hasMany(EmployeeKpiMonthly::class, 'user_id', 'user_id');
    }

    public function visitTickets()
    {
        return $this->hasMany(VisitTicket::class, 'created_by', 'user_id');
    }
}
