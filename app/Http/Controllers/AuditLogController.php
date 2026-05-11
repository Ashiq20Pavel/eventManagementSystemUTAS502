<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->action, fn($q, $a) => $q->where('action', $a))
            ->when($request->model, fn($q, $m) => $q->where('model_type', 'like', "%$m%"))
            ->latest('created_at')
            ->paginate(30);

        return view('audit.index', compact('logs'));
    }
}