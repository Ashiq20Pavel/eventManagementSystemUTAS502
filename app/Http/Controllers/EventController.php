<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\AuditLog;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Event::with('organiser');

        if ($user->isOrganiser()) {
            $query->where('organiser_id', $user->id);
        } elseif ($user->isAttendee()) {
            $query->published()->upcoming();
        }

        $query->when($request->search, fn($q, $s) =>
            $q->where('title', 'like', "%$s%")->orWhere('location', 'like', "%$s%")
        )->when($request->status, fn($q, $s) => $q->where('status', $s));

        $events = $query->latest()->paginate(12)->withQueryString();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $this->authorizeView($event);
        $event->load('organiser');

        $userTicket = null;
        if (auth()->user()->isAttendee()) {
            $userTicket = $event->tickets()->where('user_id', auth()->id())->first();
        }

        $tickets = null;
        if (auth()->user()->isStaff()) {
            $tickets = $event->tickets()->with('user')->latest('purchased_at')->get();
        }

        return view('events.show', compact('event', 'userTicket', 'tickets'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        unset($data['image']);

        if (auth()->user()->isOrganiser()) {
            $data['organiser_id'] = auth()->id();
        }

        $event = Event::create($data);

        AuditLog::record('created', Event::class, $event->id, [], $event->toArray());

        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorizeManage($event);
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorizeManage($event);

        $old = $event->toArray();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        unset($data['image']);
        $event->update($data);

        AuditLog::record('updated', Event::class, $event->id, $old, $event->fresh()->toArray());

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeManage($event);

        AuditLog::record('deleted', Event::class, $event->id, $event->toArray(), []);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted.');
    }

    private function authorizeView(Event $event): void
    {
        $user = auth()->user();
        if ($user->isAdmin()) return;
        if ($user->isOrganiser() && $event->organiser_id === $user->id) return;
        if ($user->isAttendee() && $event->status === 'published') return;
        abort(403);
    }

    private function authorizeManage(Event $event): void
    {
        $user = auth()->user();
        if ($user->isAdmin()) return;
        if ($user->isOrganiser() && $event->organiser_id === $user->id) return;
        abort(403);
    }
}