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
    <p class="mt-5 text-center text-sm text-slate-500">
        Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Sign
            in</a>
    </p>
</x-guest-layout>