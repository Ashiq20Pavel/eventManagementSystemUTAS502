@extends('layouts.app')
@section('heading', 'Organiser Dashboard')
@section('subheading', auth()->user()->name)

@section('header-actions')
    <a href="{{ route('events.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl">+ New Event</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">My Events</p>
                <p class="text-3xl font-light text-slate-800 mt-1">{{ $events->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Tickets Sold</p>
                <p class="text-3xl font-light text-slate-800 mt-1">{{ $events->sum('sold_count') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Revenue</p>
                <p class="text-3xl font-light text-indigo-600 mt-1">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Upcoming</p>
                <p class="text-3xl font-light text-slate-800 mt-1">{{ $upcomingEvents->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2">
                <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider mb-3">My Events</h2>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Event</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Date</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Sold</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($events as $e)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-3.5 font-medium text-slate-700">{{ Str::limit($e->title, 35) }}</td>
                                    <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $e->start_date->format('d M Y') }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="font-medium text-slate-700">{{ $e->sold_count }}</span>
                                        <span class="text-slate-400 text-xs">/ {{ $e->capacity }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @php $colors = ['published' => 'bg-emerald-100 text-emerald-700', 'draft' => 'bg-slate-100 text-slate-500', 'cancelled' => 'bg-red-100 text-red-600', 'completed' => 'bg-blue-100 text-blue-600'] @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $colors[$e->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($e->status) }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ route('events.show', $e) }}"
                                            class="text-indigo-600 text-xs font-medium">View →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <h2 class="text-sm font-semibold text-slate-600 uppercase tracking-wider mb-3">Recent Sales</h2>
                    <div class="space-y-2">
                        @foreach($recentTickets as $t)
                            <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-700">{{ $t->user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ Str::limit($t->event->title, 25) }}</p>
                                </div>
                                <span class="font-medium text-slate-800">${{ number_format($t->amount_paid, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection