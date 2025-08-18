<?php

namespace Arpanihan\LogManagement\ActivityLog\Services;

use App\Models\Role;
use Arpanihan\LogManagement\ActivityLog\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($action, $message = null, $url = null, $module = null, $user_id = null, $user_name = null, $user_role = null, $ip_address = null, $user_agent = null)
    {
        if (!$user_id || !$user_name) {
            $user = Auth::user();
            $user_id = $user?->id ?? 0;
            $user_name = $user?->name ?? 'Guest';
            $user_role = $user?->role ?? 'Guest';
        }

        // Optional: resolve role display name
        $roleDisplayName = $user_role;
        if (is_numeric($user_role)) {
            $role = Role::find($user_role);
            $roleDisplayName = $role?->display_name ?? $user_role;
        }

        ActivityLog::create([
            'user_id'    => $user_id,
            'user_name'  => $user_name,
            'user_role'  => $roleDisplayName,
            'action'     => $action,
            'module'     => $module,
            'url'        => $url ?? Request::fullUrl(),
            'message'    => $message,
            'ip_address' => $ip_address ?? Request::ip(),
            'user_agent' => $user_agent ?? Request::header('User-Agent'),
            'created_at' => now(),
        ]);
    }
}
