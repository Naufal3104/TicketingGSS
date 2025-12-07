<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function store(Request $request)
    {
        // Robot membuat event baru
        $event = new Event;
        $event->name = $request->title;
        $event->startDateTime = Carbon::parse($request->start_date);
        $event->endDateTime = Carbon::parse($request->end_date);
        $event->save(); // Robot menulis ke Google Calendar

        return redirect()->back()->with('success', 'Jadwal berhasil dikirim ke Google Calendar!');
    }
}
