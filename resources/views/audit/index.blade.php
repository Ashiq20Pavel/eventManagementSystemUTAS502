@extends('layouts.app')
@section('heading', 'Audit Logs')
@section('subheading', 'All model change records')

@section('content')
    <div class="space-y-4">
        <form method="GET" class="flex gap-3">
            <select name="action"
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All actions</option>
                @foreach(['created', 'updated', 'deleted', 'purchased', 'cancelled'] as $a)
                    <option value="{{ $a }}" {{ request('action') === $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
                @endforeach
            </select>
            <input type="text" name="model" value="{{ request('model') }}" placeholder="Model type filter..."
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-52">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Filter</button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">User</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Action</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Model</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">ID</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">IP</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-600">{{ $log->user?->name ?? 'System' }}</td>
                            <td class="px-5 py-3">
                                @php $ac = ['created' => 'bg-emerald-100 text-emerald-700', 'updated' => 'bg-blue-100 text-blue-700', 'deleted' => 'bg-red-100 text-red-600', 'purchased' => 'bg-indigo-100 text-indigo-700', 'cancelled' => 'bg-amber-100 text-amber-700'] @endphp
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $ac[$log->action] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($log->action) }}</span>
                            </td>
                            <td class="px-5 py-3 mono text-xs text-slate-500">{{ class_basename($log->model_type) }}</td>
                            <td class="px-5 py-3 text-slate-400 mono text-xs">{{ $log->model_id }}</td>
                            <td class="px-5 py-3 text-slate-400 mono text-xs">{{ $log->ip_address }}</td>
                            <td class="px-5 py-3 text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">No audit logs.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->withQueryString()->links() }}
    </div>
@endsection