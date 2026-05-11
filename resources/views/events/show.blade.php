@extends('layouts.app')
@section('heading', $event->title)
@section('subheading', $event->location . ' · ' . $event->start_date->format('d M Y'))

@section('header-actions')
    @if(auth()->user()->isStaff())
        <a href="{{ route('events.edit', $event) }}"
            class="bg-white border border-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-xl">Edit Event</a>
    @endif
@endsection

@section('content')
    <div class="grid grid-cols-3 gap-6">

        <div class="col-span-2 space-y-5">

            @if($event->image_path)
                <div class="h-56 rounded-2xl overflow-hidden">
                    <img src="{{ Storage::url($event->image_path) }}" class="w-full h-full object-cover"
                        alt="{{ $event->title }}">
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    @php $colors = ['published' => 'bg-emerald-100 text-emerald-700', 'draft' => 'bg-slate-100 text-slate-500', 'cancelled' => 'bg-red-100 text-red-600', 'completed' => 'bg-blue-100 text-blue-600'] @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $colors[$event->status] ?? '' }}">{{ ucfirst($event->status) }}</span>
                    @if($event->isSoldOut()) <span
                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-600">Sold
                    Out</span> @endif
                </div>
                <div class="prose prose-sm max-w-none text-slate-600 leading-relaxed">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            {{-- Ticket purchase (attendee) --}}
            @if(auth()->user()->isAttendee())
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    @if($userTicket)
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="font-semibold text-slate-800 mb-1">Your Ticket</h2>
                                <p class="mono text-sm text-indigo-600">{{ $userTicket->ticket_code }}</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $userTicket->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                {{ ucfirst($userTicket->status) }}
                            </span>
                        </div>
                        @if($userTicket->status === 'active')
                            <div class="flex items-center gap-3">
                                <a href="{{ route('tickets.show', $userTicket) }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl">View
                                    Ticket</a>
                                <form method="POST" action="{{ route('tickets.cancel', $userTicket) }}"
                                    onsubmit="return confirm('Cancel this ticket?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">Cancel
                                        ticket</button>
                                </form>
                            </div>
                        @endif
                    @elseif($event->status === 'published' && $event->isUpcoming() && !$event->isSoldOut())
                        <h2 class="font-semibold text-slate-800 mb-2">Purchase Ticket</h2>
                        <p class="text-sm text-slate-500 mb-4">
                            {{ $event->isFree() ? 'This is a free event.' : 'Price: $' . number_format($event->price, 2) . ' per ticket.' }}
                        </p>
                        <form method="POST" action="{{ route('tickets.store', $event) }}">
                            @csrf
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm">
                                {{ $event->isFree() ? 'Register Free' : 'Buy Ticket — $' . number_format($event->price, 2) }}
                            </button>
                        </form>
                    @elseif($event->isSoldOut())
                        <p class="text-slate-500 text-sm font-medium">This event is sold out.</p>
                    @else
                        <p class="text-slate-400 text-sm">Tickets are not available for this event.</p>
                    @endif
                </div>
            @endif

            {{-- Staff: tickets list --}}
            @if(auth()->user()->isStaff() && $tickets)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-semibold text-slate-700 text-sm">Ticket Sales ({{ $tickets->count() }})</h2>
                        <div class="text-xs text-slate-400">
                            Revenue: <span class="font-medium text-slate-700">${{ number_format($event->revenue(), 2) }}</span>
                        </div>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Code</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Attendee</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Paid</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Purchased</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tickets as $t)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-3 mono text-xs text-indigo-600">{{ $t->ticket_code }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $t->user->name }}</td>
                                    <td class="px-5 py-3 font-medium text-slate-700">${{ number_format($t->amount_paid, 2) }}</td>
                                    <td class="px-5 py-3">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $t->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-slate-400 text-xs">{{ $t->purchased_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-slate-400">No tickets sold yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Event Details</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Date & Time</dt>
                        <dd class="font-medium text-slate-700">{{ $event->start_date->format('l, d M Y') }}</dd>
                        <dd class="text-slate-500">{{ $event->start_date->format('g:ia') }} –
                            {{ $event->end_date->format('g:ia') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Location</dt>
                        <dd class="font-medium text-slate-700">{{ $event->location }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Price</dt>
                        <dd class="font-semibold text-slate-800">
                            {{ $event->isFree() ? 'Free' : '$' . number_format($event->price, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Capacity</dt>
                        <dd class="font-medium text-slate-700">{{ $event->soldCount() }} / {{ $event->capacity }} sold</dd>
                        <div class="mt-1.5 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full"
                                style="width: {{ min(100, ($event->soldCount() / $event->capacity) * 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-400 mb-0.5">Organiser</dt>
                        <dd class="font-medium text-slate-700">{{ $event->organiser->name }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
@endsection