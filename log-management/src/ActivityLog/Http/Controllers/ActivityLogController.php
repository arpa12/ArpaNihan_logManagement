<?php

namespace Arpanihan\LogManagement\ActivityLog\Http\Controllers;

use App\Http\Controllers\Controller;
use Arpanihan\LogManagement\ActivityLog\Services\ActivityLogger;
use Arpanihan\LogManagement\ActivityLog\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function logActivity(Request $request)
    {
        // Validate the incoming data (remove ip_address and user_agent from frontend validation)
        $validated = $request->validate([
            'user_id'    => 'required|integer',
            'user_name'  => 'required|string',
            'user_role'  => 'nullable|string',
            'action'     => 'required|string',
            'module'     => 'nullable|string',
            'url'        => 'nullable|string',
            'message'    => 'nullable|string',
        ]);

        // Add IP and user agent server-side
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->header('User-Agent');

        // Log activity
        ActivityLogger::log(
            $validated['action'],
            $validated['message'] ?? null,
            $validated['url'] ?? null,
            $validated['module'] ?? null,
            $validated['user_id'],
            $validated['user_name'],
            $validated['user_role'] ?? null,
            $validated['ip_address'],
            $validated['user_agent']
        );

        return response()->json(['message' => 'Activity logged successfully']);
    }

    public function showActivityLogs()
    {
        $activityLogs = ActivityLog::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        return view('activitylog::activity_log', compact('activityLogs'));
    }
}
