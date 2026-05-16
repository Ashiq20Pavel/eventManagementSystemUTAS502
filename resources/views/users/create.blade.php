@extends('layouts.app')
@section('heading', 'Create User')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-slate-400 mt-1.5">Enter a valid email (e.g. user@example.com)</p>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Role</label>
                    <select name="role"
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['attendee', 'organiser', 'admin'] as $r)
                            <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>
                                {{ ucfirst($r) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-slate-400 mt-1.5">
                        Min 8 characters · 1 uppercase · 1 number · 1 special character (e.g. <span
                            class="font-mono">Admin@2025</span>)
                    </p>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl">
                        Create User
                    </button>
                    <a href="{{ route('users.index') }}" class="text-slate-500 text-sm">Cancel</a>
                </div>

            </form>
        </div>
    </div>
@endsection