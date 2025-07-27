<?php

use Illuminate\Support\Facades\Route;
use Arpanihan\LogManagement\ActivityLog\Http\Controllers\ActivityLogController;

Route::post('/log-activity', [ActivityLogController::class, 'logActivity']);
Route::get('/activity-log', [ActivityLogController::class, 'showActivityLogs']);
