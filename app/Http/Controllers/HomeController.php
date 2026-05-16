<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $featuredEvents = Event::published()
            ->upcoming()
            ->with('organiser')
            ->orderBy('start_date')
            ->take(6)
            ->get();

        $stats = [
            'events'     => Event::published()->count(),
            'tickets'    => Ticket::where('status', 'active')->count(),
            'users'      => User::where('role', 'attendee')->count(),
            'organisers' => User::where('role', 'organiser')->count(),
        ];

        return view('home', compact('featuredEvents', 'stats'));
    }
}