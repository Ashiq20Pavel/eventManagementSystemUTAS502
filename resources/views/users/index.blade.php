@extends('layouts.app')
@section('heading', 'Users')

@section('header-actions')
    <a href="{{ route('users.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-xl">+ New User</a>
@endsection

@section('content')
    <div class="space-y-5">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
            <select name="role"
                class="rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All roles</option>
                @foreach(['admin', 'organiser', 'attendee'] as $r)
                    <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm">Filter</button>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Name</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Email</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Role</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase">Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 {{ $user->trashed() ? 'opacity-50' : '' }}">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $user->email }}</td>
                            <td class="px-5 py-3.5">
                                @php $rc = ['admin' => 'bg-purple-100 text-purple-700', 'organiser' => 'bg-indigo-100 text-indigo-700', 'attendee' => 'bg-slate-100 text-slate-500'] @endphp
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $rc[$user->role] ?? '' }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($user->trashed())
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-600">Deleted</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">Active</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    @if($user->trashed())
                                        <form method="POST" action="{{ route('users.restore', $user->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-xs text-emerald-600 font-medium">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-indigo-600 text-xs font-medium">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                onsubmit="return confirm('Delete {{ $user->name }}? (Soft delete)')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs text-red-400 hover:text-red-600">Delete</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->withQueryString()->links() }}
    </div>
@endsection