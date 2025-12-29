<?php

namespace App\Http\Controllers\CustomerService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerFeedback;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Get Average Ratings for each TS
        // Join Users (TS) with Tickets -> Feedback

        $tsRatings = DB::table('users')
            ->join('visit_assignments', 'users.user_id', '=', 'visit_assignments.ts_id')
            ->join('visit_tickets', 'visit_assignments.visit_ticket_id', '=', 'visit_tickets.visit_ticket_id')
            ->join('customer_feedback', 'visit_tickets.visit_ticket_id', '=', 'customer_feedback.visit_ticket_id')
            ->select(
                'users.name',
                DB::raw('COUNT(customer_feedback.feedback_id) as total_reviews'),
                DB::raw('AVG(customer_feedback.rating_ts) as avg_rating')
            )
            ->groupBy('users.user_id', 'users.name')
            ->orderByDesc('avg_rating')
            ->get();

        return view('admin.reports.index', compact('tsRatings'));
    }
}
