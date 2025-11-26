<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeKpiMonthly extends Model
{
    protected $table = 'employee_kpi_monthly';
    protected $primaryKey = 'kpi_id';

    protected $fillable = [
        'user_id',
        'period_month',
        'total_tasks',
        'avg_rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
