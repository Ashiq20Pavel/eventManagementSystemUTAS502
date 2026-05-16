<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-800">Create account</h1>
        <p class="text-slate-500 text-sm mt-1">Join EventPortal today.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <p class="text-xs text-slate-400 mt-1.5">Enter a valid email (e.g. user@example.com)</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">I want to</label>
            <select name="role"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="attendee" {{ old('role') === 'attendee' ? 'selected' : '' }}>Attend events</option>
                <option value="organiser" {{ old('role') === 'organiser' ? 'selected' : '' }}>Organise events</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password" required minlength="8"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <p class="text-xs text-slate-400 mt-1.5">
                Min 8 characters · 1 uppercase · 1 number · 1 special character (e.g. <span
                    class="mono">Admin@2025</span>)
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 text-sm font-medium">
            Create account
        </button>
    </form>

    <!-- <p class="mt-5 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Sign in</a>
    </p> -->
    <p class="mt-5 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Sign in</a>
    </p>

    <p class="mt-3 text-center text-sm text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-slate-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Home
        </a>
    </p>
</x-guest-layout>