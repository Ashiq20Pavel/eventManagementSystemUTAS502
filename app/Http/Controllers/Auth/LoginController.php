<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Laravel's Auth uses getAuthPassword() which maps to password_hash
        $attempted = Auth::attempt([
            'email'         => $credentials['email'],
            'password_hash' => $credentials['password'],
        ], $request->boolean('remember'));

        // Fallback: manual attempt since column name is non-standard
        if (!$attempted) {
            $user = User::where('email', $credentials['email'])->first();

            if ($user && \Hash::check($credentials['password'], $user->password_hash)) {
                Auth::login($user, $request->boolean('remember'));
                $attempted = true;
            }
        }

        if (!$attempted) {
            $user = User::where('email', $credentials['email'])->first();
            AuthLog::record($user?->id, 'failed_login', false, 'Invalid credentials');

            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        AuthLog::record(Auth::id(), 'login', true);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        AuthLog::record(Auth::id(), 'logout', true);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}