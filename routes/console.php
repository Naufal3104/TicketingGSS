<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\VisitTicket;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $now = Carbon::now();

    // Check for late check-ins:
    // Tickets that are ASSIGNED (meaning no check-in yet, as check-in moves to IN_PROGRESS)
    // And scheduled time + 30 mins is in the past

    $tickets = VisitTicket::where('status', 'ASSIGNED')
        ->whereNotNull('visit_date')
        ->whereNotNull('visit_time')
        ->get();

    foreach ($tickets as $ticket) {
        try {
            $schedule = Carbon::parse($ticket->visit_date . ' ' . $ticket->visit_time);

            // If now is more than 30 minutes past the scheduled time
            // diffInMinutes returns negative if $schedule is in the past relative to $now? No.
            // $schedule->diffInMinutes($now, false). If schedule is past, result is positive if $now is future.

            // Example: Schedule 10:00. Now 10:31.
            // $schedule->diffInMinutes($now, false) = 31.

            if ($schedule->diffInMinutes($now, false) > 30) {
                Log::warning("[EMERGENCY] Late Check-in detected for Ticket: {$ticket->visit_ticket_id}. Scheduled: {$schedule->toDateTimeString()}");
                // In production, send Telegram notification here
            }
        } catch (\Exception $e) {
            Log::error("Error in Emergency Schedule check: " . $e->getMessage());
        }
    }
})->everyMinute();
