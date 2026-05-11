@extends('layouts.app')
@section('heading', 'Admin Dashboard')

@section('header-actions')
    <a href="{{ route('events.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl">+ New Event</a>
    <a href="{{ route('users.create') }}"
        class="bg-white border border-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-xl">+ New User</a>
@endsection

@section('content')
    <div class="space-y-6">

        {{-- Stats --}}
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach([
                    ['Total Events', $stats['total_events'], 'text-slate-800'],
                    ['Published', $stats['published'], 'text-emerald-600'],
                    ['Tickets Sold', $stats['total_tickets'], 'text-slate-800'],
                    ['Revenue', '$' . number_format($stats['total_revenue'], 2), 'text-indigo-600'],
                    ['Total Users', $stats['total_users'], 'text-slate-800'],
                    ['Organisers', $stats['organisers'], 'text-slate-800'],
                ] as [$label, $value, $color])
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $label }}</p>
                    <p class="text-2xl font-light {{ $color }} mt-1">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-3 gap-6">
            {{-- Recent Events --}}
            <div class="col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Recent Events</h2>
                    <a href="{{ route('events.index') }}" class="text-xs text-indigo-600">View all →</a>

                                            </div>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Event</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Organiser</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                                <th class="text-left px-5 py-3 text-xs font-
                  s                     emibold text-slate-400 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentEvents as $e)
                                                <tr class="ho
                                v                           er:bg-slate-50">
                                                    <td class="px-5 py-3.5">
                                                        <a href="{{ route('events.show', $e) }}" class="font-medium text-slate-700 hover:text-indigo-600">{{ Str::limit($e->title, 35) }}</a>
                                                    </td>
                                                    <td class="px-5 py-3.5 text-slate-400">{{ $e->organiser->name }}</td>
                                                    <td class="px-5 py-3.5">
                                                        @php $colors = ['published' => 'bg-emerald-100 text-emerald-700', 'draft' => 'bg-slate-100 text-slate-500', 'cancelled' => 'bg-red-100 text-red-600', 'completed' => 'bg-blue-100 text-blue-600'] @endphp
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $colors[$e->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($e->status) }}</span>
                                                    </td>
                                                    <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $e->start_date->format('d M Y') }}</td>
                                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


             {{-- Recent Auth Logs --}}
            <div>
                <div class="
    f                       lex items-center justify-between mb-3">

                                        <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Auth Activity</h2>
                    <a href="{{ route('auth-logs.index') }}" class="text-xs text-indigo-600">View all →</a>
                </div>

                                           <div class="bg-white rounded-2xl border border-slate-200 divide-y divide-slate-100 max-h-80 overflow-y-auto">
                    @foreach($recentAuthLogs as $log)
                        <div class="px-4 py-3 flex items-center gap-3">
                            <div class="w-1.5 h-1.5 rounded-full {{ $log->success ? 'bg-emerald-400' : 'bg-red-400' }} flex-shrink-0"></div>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-slate-700 truncate">{{ $log->user?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-slate-400">{{ str_replace('_', ' ', $log->event_type) }} · {{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Ticket Sales --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Recent Ticket Sales</h2>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Code</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Attendee</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Event</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Amount</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Purchased</th>
                            <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentTickets as $t)
                            <tr class="ho
                                       ver:bg-slate-50">
                                <td class="px-5 py-3.5 mono text-xs text-indigo-600">{{ $t->ticket_code }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $t->user->name }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ Str::limit($t->event->title, 30) }}</td>
                                <td class="px-5 py-3.5 font-medium text-slate-700">${{ number_format($t->amount_paid, 2) }}</td>
                                <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $t->purchased_at->diffForHumans() }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $t->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection