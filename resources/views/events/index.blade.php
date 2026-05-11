@extends('layouts.app')
@section('heading', 'Events')

@section('header-actions')
    @if(auth()->user()->isStaff())
        <a href="{{ route('events.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl">+ New Event</a>
    @endif
@endsection

@section('content')
    <div class="space-y-5">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
            @if(auth()->user()->isStaff())
                <select name="status"
                    class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All statuses</option>
                    @foreach(['draft', 'published', 'cancelled', 'completed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            @endif
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Search</button>
        </form>

        @if($events->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <p class="text-slate-400">No events found.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($events as $event)
                    <div
                        class="bg-white rounded-2xl border border-slate-200 hover:border-indigo-200 hover:shadow-sm transition-all overflow-hidden flex flex-col">
                        @if($event->image_path)
                            <div class="h-36 bg-slate-100 overflow-hidden">
                                <img src="{{ Storage::url($event->image_path) }}" class="w-full h-full object-cover"
                                    alt="{{ $event->title }}">
                            </div>
                        @else
                            <div class="h-36 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                        @endif

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-start justify-between mb-2">
                                @php $colors = ['published' => 'bg-emerald-100 text-emerald-700', 'draft' => 'bg-slate-100 text-slate-500', 'cancelled' => 'bg-red-100 text-red-600', 'completed' => 'bg-blue-100 text-blue-600'] @endphp
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $colors[$event->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($event->status) }}</span>
                                <span
                                    class="font-semibold text-slate-800">{{ $event->isFree() ? 'Free' : '$' . number_format($event->price, 2) }}</span>
                            </div>

                            <h3 class="font-semibold text-slate-800 mb-1">{{ $event->title }}</h3>
                            <p class="text-sm text-slate-500 mb-3 flex-1">{{ Str::limit($event->description, 80) }}</p>

                            <div class="space-y-1 text-xs text-slate-400 mb-4">
                                <p>📍 {{ Str::limit($event->location, 40) }}</p>
                                <p>📅 {{ $event->start_date->format('d M Y, g:ia') }}</p>
                                <p>🎟 {{ $event->availableSpots() }} / {{ $event->capacity }} spots available</p>
                            </div>

                            <a href="{{ route('events.show', $event) }}"
                                class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>{{ $events->links() }}</div>
        @endif
    </div>
@endsection