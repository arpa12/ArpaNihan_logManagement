<?php

namespace Arpanihan\LogManagement\ActionLog\Services;

use Arpanihan\LogManagement\ActionLog\Models\ActionLog;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActionLogger
{
    public static function log($action, $message = null, $url = null, $module = null)
    {
        $user = Auth::user();

        //  Get display_name from roles table
        $roleDisplayName = null;

        if ($user && $user->role) {
            if (is_numeric($user->role)) {
                // Case: users.role stores role_id
                $roleModel = Role::find($user->role);
            } else {
                // Case: users.role stores role name
                $roleModel = Role::where('name', $user->role)->first();
            }
            $roleDisplayName = $roleModel?->display_name ?? 'N/A';
        }

        ActionLog::create([
            'user_id'     => $user?->id ?? 0,
            'user_name'   => $user?->name ?? 'Guest',
            'user_role'   => $roleDisplayName ?? 'Guest',
            'action'      => $action,
            'module'      => $module,
            'url'         => $url ?? Request::fullUrl(),
            'message'     => $message,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::header('User-Agent'),
            'created_at'  => now(),
        ]);
    }
}
