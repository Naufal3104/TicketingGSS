<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitTicket;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Display a monitoring dashboard for Field Operations.
     */
    public function index()
    {
        // Get visits scheduled for TODAY
        $today = Carbon::today()->toDateString();

        $todaysVisits = VisitTicket::with(['customer', 'assignment.ts'])
            ->whereDate('visit_date', $today)
            ->orderBy('visit_time', 'asc')
            ->get();

        // Calculate Stats
        $stats = [
            'total' => $todaysVisits->count(),
            'completed' => $todaysVisits->whereIn('status', ['COMPLETED', 'COMPLETED_PENDING_DOCS'])->count(),
            'on_site' => $todaysVisits->where('status', 'IN_PROGRESS')->count(),
            'pending' => $todaysVisits->whereIn('status', ['ASSIGNED', 'OPEN'])->count(),
        ];

        return view('operational.monitoring.index', compact('todaysVisits', 'stats', 'today'));
    }
}
