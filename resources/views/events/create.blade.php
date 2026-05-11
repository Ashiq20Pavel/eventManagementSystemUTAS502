@extends('layouts.app')
@section('heading', 'Create Event')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-300 @enderror">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Description <span
                            class="text-red-500">*</span></label>
                    <textarea name="description" rows="5" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Date & Time <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">End Date & Time <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Location <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Venue name, Address, City">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Capacity <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Price ($) <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', '0.00') }}" min="0" step="0.01" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach(['draft', 'published', 'cancelled'] as $s)
                                <option value="{{ $s }}" {{ old('status', 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Event Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                @if(auth()->user()->isAdmin())
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Organiser</label>
                        <select name="organiser_id"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach(\App\Models\User::whereIn('role', ['organiser', 'admin'])->orderBy('name')->get() as $u)
                                <option value="{{ $u->id }}" {{ old('organiser_id', auth()->id()) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl">
                        Create Event
                    </button>
                    <a href="{{ route('events.index') }}" class="text-slate-500 text-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection