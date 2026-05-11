@extends('layouts.app')
@section('heading', 'My Dashboard')
@section('subheading', 'Welcome back, ' . auth()->user()->name)

@section('header-actions')
    <a href="{{ route('events.index') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl">Browse Events</a>
@endsection

@section('content')
    <div class="space-y-6">

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">My Tickets</p>
                <p class="text-3xl font-light text-slate-800 mt-1">{{ $myTickets->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Upcoming Events</p>
                <p class="text-3xl font-light text-slate-800 mt-1">
                    {{ $myTickets->filter(fn($t) => $t->event->start_date->isFuture())->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">

            {{-- My Tickets --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider">My Tickets</h2>
                    <a href="{{ route('tickets.index') }}" class="text-xs text-indigo-600">View all →</a>
                </div>
                <div class="space-y-3">
                    @forelse($myTickets->take(5) as $ticket)
                        <div
                            class="bg-white rounded-2xl border border-slate-200 p-5 {{ $ticket->status === 'cancelled' ? 'opacity-60' : '' }}">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $ticket->event->title }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $ticket->event->location }}</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $ticket->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="mono text-xs text-indigo-600">{{ $ticket->ticket_code }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        {{ $ticket->event->start_date->format('d M Y, g:ia') }}</p>
                                </div>
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-xs text-indigo-600 font-medium">View
                                    →</a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center">
                            <p class="text-slate-400 text-sm">No tickets yet.</p>
                            <a href="{{ route('events.index') }}" class="text-indigo-600 text-sm font-medium mt-2 block">Browse
                                events</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Discover Events --}}
            <div>
                <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider mb-3">Discover Events</h2>
                <div class="space-y-3">
                    @forelse($upcomingEvents as $event)
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-indigo-200 transition-colors">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $event->title }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $event->location }}</p>
                                </div>
                                <span
                                    class="font-semibold text-slate-800">{{ $event->isFree() ? 'Free' : '$' . number_format($event->price, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-400">{{ $event->start_date->format('d M Y') }} ·
                                    {{ $event->availableSpots() }} spots left</p>
                                <a href="{{ route('events.show', $event) }}" class="text-xs text-indigo-600 font-medium">Get
                                    ticket →</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">No upcoming events.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection