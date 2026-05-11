<?php

namespace App\Http\Controllers;

use App\Models\AuthLog;
use Illuminate\Http\Request;

class AuthLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuthLog::with('user')
            ->when($request->event_type, fn($q, $t) => $q->where('event_type', $t))
            ->when($request->success !== null && $request->success !== '', fn($q) =>
                $q->where('success', $request->boolean('success'))
            )
            ->latest('created_at')
            ->paginate(30);

        return view('auth-logs.index', compact('logs'));
    }
}