@extends('layouts.app')
@section('heading', 'Edit User')
@section('subheading', $user->email)

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">

            {{-- UPDATE FORM --}}
            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-slate-400 mt-1.5">Enter a valid email (e.g. user@example.com)</p>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
                    <select name="role"
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['attendee', 'organiser', 'admin'] as $r)
                            <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>
                                {{ ucfirst($r) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl">
                            Save Changes
                        </button>
                        <a href="{{ route('users.index') }}" class="text-slate-500 text-sm">Cancel</a>
                    </div>
                </div>
            </form>

            {{-- DELETE FORM — outside the update form --}}
            @if($user->id !== auth()->id())
                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                    <form method="POST" action="{{ route('users.destroy', $user) }}"
                        onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm font-medium hover:text-red-600">
                            Delete user
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
@endsection