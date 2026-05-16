<x-guest-layout>
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-6 lg:hidden">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
            </div>
            <span class="font-semibold">EventPortal</span>
        </div>
        <h1 class="text-2xl font-semibold text-slate-800">Sign in</h1>
        <p class="text-slate-500 text-sm mt-1">Welcome back — enter your credentials below.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600"> Remember me
            </label>
        </div>
        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 text-sm font-medium transition-colors">
            Sign in
        </button>
    </form>

    <!-- <p class="mt-5 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Register</a>
    </p> -->
    <p class="mt-5 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Register</a>
    </p>

    <p class="mt-3 text-center text-sm text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-slate-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Home
        </a>
    </p>

    <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs font-mono space-y-1 text-slate-500">
        <p class="font-sans text-xs font-semibold text-slate-600 mb-2">Demo accounts (password: <span
                class="mono">password</span>)</p>
        <p><span class="text-slate-700">Admin:</span> admin@eventportal.com</p>
        <p><span class="text-slate-700">Organiser:</span> sarah@eventsco.com</p>
        <p><span class="text-slate-700">Attendee:</span> alice@example.com</p>
    </div>
</x-guest-layout>