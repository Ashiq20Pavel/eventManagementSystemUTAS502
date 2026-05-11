@extends('layouts.app')
@section('heading', 'Auth Logs')
@section('subheading', 'Login, logout and authentication events')

@section('content')
    <div class="space-y-4">
        <form method="GET" class="flex gap-3">
            <select name="event_type"
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All events</option>
                @foreach(['login', 'logout', 'failed_login', 'register', 'password_reset'] as $t)
                    <option value="{{ $t }}" {{ request('event_type') === $t ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', ucfirst($t)) }}</option>
                @endforeach
            </select>
            <select name="success"
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All outcomes</option>
                <option value="1" {{ request('success') === '1' ? 'selected' : '' }}>Success</option>
                <option value="0" {{ request('success') === '0' ? 'selected' : '' }}>Failed</option>
            </select>
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Filter</button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">User</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Event</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Result</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Reason</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">IP</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-600">{{ $log->user?->name ?? 'Unknown' }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ str_replace('_', ' ', ucfirst($log->event_type)) }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $log->success ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $log->success ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $log->success ? 'Success' : 'Failed' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-400 text-xs">{{ $log->failure_reason ?? '—' }}</td>
                            <td class="px-5 py-3 mono text-xs text-slate-400">{{ $log->ip_address }}</td>
                            <td class="px-5 py-3 text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">No auth logs.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->withQueryString()->links() }}
    </div>
@endsection