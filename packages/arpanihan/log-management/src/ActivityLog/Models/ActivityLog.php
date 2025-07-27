<?php

namespace Arpanihan\LogManagement\ActivityLog\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id', 'user_name', 'user_role', 'action', 'module',
        'url', 'message', 'ip_address', 'user_agent'
    ];

    public $timestamps = true;
}
