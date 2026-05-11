<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $user = auth()->user();

        abort_unless($user->isAttendee(), 403, 'Only attendees can purchase tickets.');
        abort_unless($event->status === 'published', 422, 'This event is not available.');
        abort_if($event->isSoldOut(), 422, 'This event is sold out.');

        // Prevent duplicate tickets
        if ($event->tickets()->where('user_id', $user->id)->where('status', 'active')->exists()) {
            return back()->with('error', 'You already have a ticket for this event.');
        }

        $ticket = Ticket::create([
            'event_id'     => $event->id,
            'user_id'      => $user->id,
            'ticket_code'  => strtoupper(Str::random(8) . '-' . Str::random(4)),
            'status'       => 'active',
            'amount_paid'  => $event->price,
            'purchased_at' => now(),
        ]);

        AuditLog::record('purchased', Ticket::class, $ticket->id, [], $ticket->toArray());

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket purchased successfully!');
    }

    public function show(Ticket $ticket)
    {
        $user = auth()->user();
        abort_unless(
            $user->isAdmin() || $ticket->user_id === $user->id,
            403
        );

        $ticket->load(['event.organiser', 'user']);
        return view('tickets.show', compact('ticket'));
    }

    public function cancel(Ticket $ticket)
    {
        $user = auth()->user();
        abort_unless(
            $user->isAdmin() || $ticket->user_id === $user->id,
            403
        );
        abort_if($ticket->status !== 'active', 422, 'Ticket is already cancelled.');

        $old = $ticket->toArray();
        $ticket->update(['status' => 'cancelled']);

        AuditLog::record('cancelled', Ticket::class, $ticket->id, $old, $ticket->fresh()->toArray());

        return back()->with('success', 'Ticket cancelled.');
    }

    public function myTickets()
    {
        $tickets = auth()->user()->tickets()
            ->with('event')
            ->latest('purchased_at')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }
}