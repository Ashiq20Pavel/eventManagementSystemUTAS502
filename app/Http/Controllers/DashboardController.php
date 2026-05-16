<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\AuthLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isOrganiser()) {
            return $this->organiserDashboard($user);
        }

        return $this->attendeeDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_events' => Event::count(),
            'published' => Event::where('status', 'published')->count(),
            'total_tickets' => Ticket::where('status', 'active')->count(),
            'total_revenue' => Ticket::where('status', 'active')->sum('amount_paid'),
            'total_users' => User::count(),
            'organisers' => User::where('role', 'organiser')->count(),
        ];

        $recentEvents = Event::with('organiser')->latest()->take(6)->get();
        $recentTickets = Ticket::with(['user', 'event'])->latest('purchased_at')->take(8)->get();
        $recentAuthLogs = AuthLog::with('user')->latest('created_at')->take(10)->get();

        return view('dashboard.admin', compact('stats', 'recentEvents', 'recentTickets', 'recentAuthLogs'));
    }

    private function organiserDashboard(User $user)
    {
        $events = $user->organisedEvents()->withCount([
            'tickets as sold_count' => fn($q) =>
                $q->where('status', 'active')
        ])->latest()->get();

        $totalRevenue = $user->organisedEvents()
            ->join('tickets', 'events.id', '=', 'tickets.event_id')
            ->where('tickets.status', 'active')
            ->sum('tickets.amount_paid');

        $recentTickets = Ticket::whereHas('event', fn($q) => $q->where('organiser_id', $user->id))
            ->with(['user', 'event'])
            ->latest('purchased_at')
            ->take(8)
            ->get();

        $upcomingEvents = $user->organisedEvents()
            ->published()
            ->upcoming()
            ->orderBy('start_date')
            ->take(3)
            ->get();

        return view('dashboard.organiser', compact(
            'events',
            'totalRevenue',
            'recentTickets',
            'upcomingEvents'
        ));
    }

    private function attendeeDashboard(User $user)
    {
        $myTickets = $user->tickets()
            ->with('event.organiser')
            ->latest('purchased_at')
            ->get();

        $upcomingEvents = Event::published()
            ->upcoming()
            ->whereDoesntHave('tickets', fn($q) => $q->where('user_id', $user->id))
            ->orderBy('start_date')
            ->take(6)
            ->get();

        return view('dashboard.attendee', compact('myTickets', 'upcomingEvents'));
    }
}