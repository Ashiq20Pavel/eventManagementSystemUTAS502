@extends('layouts.app')
@section('heading', 'My Tickets')

@section('content')
    <div class="space-y-4">
        @forelse($tickets as $ticket)
            <div
                class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-5 {{ $ticket->status === 'cancelled' ? 'opacity-60' : '' }}">
                <div
                    class="w-1 self-stretch rounded-full {{ $ticket->status === 'active' ? 'bg-indigo-500' : 'bg-slate-200' }}">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $ticket->event->title }}</p>
                            <p class="text-sm text-slate-400 mt-0.5">{{ $ticket->event->location }}</p>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-4 flex-shrink-0 {{ $ticket->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-6 mt-3 text-xs text-slate-400">
                        <span class="mono text-indigo-600 font-medium">{{ $ticket->ticket_code }}</span>
                        <span>📅 {{ $ticket->event->start_date->format('d M Y, g:ia') }}</span>
                        <span>💰
                            {{ (float) $ticket->amount_paid === 0.0 ? 'Free' : '$' . number_format($ticket->amount_paid, 2) }}</span>
                    </div>
                </div>
                <!-- <a href="{{ route('tickets.show', $ticket) }}"
                            class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2 rounded-xl flex-shrink-0 transition-colors">
                            View
                        </a> -->
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('tickets.show', $ticket) }}"
                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium px-4 py-2 rounded-xl transition-colors">
                        View
                    </a>
                    @if($ticket->status === 'active')
                        <a href="{{ route('tickets.pdf', $ticket) }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            PDF
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <p class="text-slate-400 mb-3">No tickets yet.</p>
                <a href="{{ route('events.index') }}"
                    class="bg-indigo-600 text-white text-sm font-medium px-5 py-2.5 rounded-xl">Browse Events</a>
            </div>
        @endforelse

        {{ $tickets->links() }}
    </div>
@endsection