<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withTrashed()
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")
            )
            ->when($request->role, fn($q, $r) => $q->where('role', $r))
            ->latest()
            ->paginate(20);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:191|unique:users',
            'role'     => 'required|in:admin,organiser,attendee',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'role'          => $data['role'],
            'password_hash' => Hash::make($data['password']),
        ]);

        AuditLog::record('created', User::class, $user->id, [], $user->toArray());

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => 'required|in:admin,organiser,attendee',
        ]);

        $old = $user->toArray();
        $user->update($data);

        AuditLog::record('updated', User::class, $user->id, $old, $user->fresh()->toArray());

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Cannot delete yourself.');

        AuditLog::record('deleted', User::class, $user->id, $user->toArray(), []);
        $user->delete(); // soft delete

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function restore(User $user)
    {
        $user->restore();
        return redirect()->route('users.index')->with('success', 'User restored.');
    }
}