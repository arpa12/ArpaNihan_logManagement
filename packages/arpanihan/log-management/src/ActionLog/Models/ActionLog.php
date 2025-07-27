<?php

namespace Arpanihan\LogManagement\ActionLog\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_logs';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'url',
        'message',
        'module',
        'user_agent',
        'ip_address',
        'created_at'
    ];

}
