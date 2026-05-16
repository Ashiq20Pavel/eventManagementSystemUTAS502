@extends('layouts.app')
@section('heading', 'Ticket')
@section('subheading', $ticket->event->title)

@section('content')
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">

            {{-- Ticket header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-8 py-8 text-white">
                <p class="text-indigo-200 text-sm mb-1">EventPortal Ticket</p>
                <h2 class="text-2xl font-semibold mb-0.5">{{ $ticket->event->title }}</h2>
                <p class="text-indigo-200">{{ $ticket->event->location }}</p>
            </div>

            {{-- Ticket code --}}
            <div class="px-8 py-6 border-b border-dashed border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Ticket Code</p>
                    <p class="mono text-2xl font-medium text-indigo-600 tracking-widest">{{ $ticket->ticket_code }}</p>
                </div>
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-medium {{ $ticket->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                    {{ ucfirst($ticket->status) }}
                </span>
            </div>

            {{-- Details --}}
            <div class="px-8 py-6">
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Attendee</dt>
                        <dd class="font-medium text-slate-700">{{ $ticket->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Amount Paid</dt>
                        <dd class="font-semibold text-slate-800">
                            {{ (float) $ticket->amount_paid === 0.0 ? 'Free' : '$' . number_format($ticket->amount_paid, 2) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Event Date</dt>
                        <dd class="font-medium text-slate-700">{{ $ticket->event->start_date->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Event Time</dt>
                        <dd class="font-medium text-slate-700">{{ $ticket->event->start_date->format('g:ia') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Purchased</dt>
                        <dd class="font-medium text-slate-700">{{ $ticket->purchased_at->format('d M Y, g:ia') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Organiser</dt>
                        <dd class="font-medium text-slate-700">{{ $ticket->event->organiser->name }}</dd>
                    </div>
                </dl>
            </div>

            <!-- @if($ticket->status === 'active' && auth()->id() === $ticket->user_id)
                        <div class="px-8 pb-6 flex items-center gap-3">
                            <a href="{{ route('events.show', $ticket->event) }}" class="text-sm text-indigo-600 font-medium">← Back to
                                event</a>
                            <form method="POST" action="{{ route('tickets.cancel', $ticket) }}"
                                onsubmit="return confirm('Cancel this ticket?')" class="ml-auto">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">Cancel ticket</button>
                            </form>
                        </div>
                    @endif -->
            <div class="px-8 pb-6 flex items-center gap-3">
                <a href="{{ route('events.show', $ticket->event) }}" class="text-sm text-indigo-600 font-medium">← Back to
                    event</a>

                {{-- Download PDF button --}}
                @if($ticket->status === 'active')
                    <a href="{{ route('tickets.pdf', $ticket) }}"
                        class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download PDF
                    </a>
                @endif

                @if($ticket->status === 'active' && auth()->id() === $ticket->user_id)
                    <form method="POST" action="{{ route('tickets.cancel', $ticket) }}"
                        onsubmit="return confirm('Cancel this ticket?')" class="ml-auto">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">Cancel ticket</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection