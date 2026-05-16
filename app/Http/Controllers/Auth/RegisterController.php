<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuthLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            // 'email' => 'required|email|max:191|unique:users',
            'email' => [
                'required',
                'string',
                'max:191',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/',
            ],
            // 'password' => 'required|string|min:8|confirmed',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).+$/',
            ],
            'role' => 'required|in:attendee,organiser',
        ], [
            'name.required' => 'Name is required.',
            'email.regex'    => 'Please enter a valid email address (e.g. user@example.com).',
            'email.unique' => 'This email is already registered.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        AuthLog::record($user->id, 'register', true);
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}