<?php

use Illuminate\Support\Facades\Route;
use Arpanihan\LogManagement\ActionLog\Http\Controllers\ActionLogController;

Route::get('/actionLog', [ActionLogController::class, 'index'])->name('actionlogs.index');
