@extends('layouts.app')
@section('heading', 'Edit Event')
@section('subheading', $event->title)

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data"
                class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea name="description" rows="5" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Date & Time</label>
                        <input type="datetime-local" name="start_date"
                            value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">End Date & Time</label>
                        <input type="datetime-local" name="end_date"
                            value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Location</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Price ($)</label>
                        <input type="number" name="price" value="{{ old('price', $event->price) }}" min="0" step="0.01"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                        <select name="status"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach(['draft', 'published', 'cancelled', 'completed'] as $s)
                                <option value="{{ $s }}" {{ old('status', $event->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($event->image_path)
                    <div>
                        <p class="text-xs font-medium text-slate-500 mb-2">Current image</p>
                        <img src="{{ Storage::url($event->image_path) }}" class="h-28 rounded-xl object-cover" alt="Current">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Replace Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl">Save
                            Changes</button>
                        <a href="{{ route('events.show', $event) }}" class="text-slate-500 text-sm">Cancel</a>
                    </div>
                    <form method="POST" action="{{ route('events.destroy', $event) }}"
                        onsubmit="return confirm('Delete this event?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600 text-sm font-medium">Delete
                            event</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
@endsection